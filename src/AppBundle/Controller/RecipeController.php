<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\Type\RecipeType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RecipeController
 * @package Van\RecipeBundle\Controller
 */
class RecipeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine();

        $scope = $em->getRepository('AppBundle:Scope')->findOneBy(['slug' => 'public']);
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findBy(['scope' => $scope]);

        return $this->render('AppBundle:Recipe:index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myAction()
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findBy(["user" => $this->getUser()]);

        return $this->render('AppBundle:Recipe:my.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipe = new Recipe();

        /**
         * todo: to remove
         */
//        $ingredient = new Ingredient();
//        $ingredient->setName('Poulet');
//        $em->persist($ingredient);
//        $recipeIngredient = new RecipeIngredient();
//        $recipeIngredient->setIngredient($ingredient);
//        $recipe->addIngredient($recipeIngredient);

        $form = $this->createForm(RecipeType::class, $recipe);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $recipe->setUser($this->getUser());

                $em->persist($recipe);
                $em->flush();

                // update api.ai entry
                $response = $this->get("app.api.client")->updateRecipeEntry($recipe);

                $this->get('session')->getFlashBag()->add('success', 'Votre recette a été enregistrée.');

                return $this->redirect($this->generateUrl('app.recipe.my'));
            } else {
                dump((string) $form->getErrors());
                die();
            }
        }

        return $this->render('@App/Recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return Response
     */
    public function readAction(Request $request, Recipe $recipe)
    {
        return $this->render('@App/Recipe/read.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return RedirectResponse|Response
     */
    public function updateAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RecipeType::class, $recipe);

        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($recipe->getTags() as $tag) {
            $originalTags->add($tag);
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                // remove the relationship between the tag and the Task
                foreach ($originalTags as $tag) {
                    if (false === $recipe->getTags()->contains($tag)) {
                        // remove the Task from the Tag
                        $tag->getRecipes()->removeElement($recipe);

                        $this->getDoctrine()->getManager()->persist($tag);
                    }
                }

                // re-building relation on existing tag
                foreach ($recipe->getTags() as $tag) {
                    $dbTag = $em->getRepository('AppBundle:Tag')->findOneBy(['name' => $tag->getName()]);

                    if (null !== $dbTag) {
                        $recipe->getTags()->removeElement($tag);
                        $recipe->addTag($dbTag);
                    }
                }


                $em->flush();

                // update api.ai entry
                $response = $this->get("app.api.client")->updateRecipeEntry($recipe);

                $this->get('session')->getFlashBag()->add('success', 'Votre recette a été mise à jour.');

                return $this->redirect($this->generateUrl('app.recipe.my'));
            } else {
                dump((string) $form->getErrors());
                die();
            }
        }

        return $this->render('@App/Recipe/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Recipe $recipe
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        if ($recipe->getUser() !== $this->getUser()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();

        // update api.ai entry
        $response = $this->get("app.api.client")->updateRecipeEntry($recipe);

        $this->get('session')->getFlashBag()->add('success', 'Votre recette a été supprimée.');

        return new RedirectResponse($this->generateUrl("app.recipe.my"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function collectAction(Request $request, $id)
    {
        $original = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find($id);

        $recipe = clone $original;

        $recipe
            ->setUser($this->getUser())
        ;

        $this->getDoctrine()->getManager()->persist($recipe);
        $this->getDoctrine()->getManager()->flush();

        $request->getSession()->getFlashBag()->add('success', 'La recette a été ajoutée à votre collection.');

        return new RedirectResponse($this->generateUrl('app.user.details', ['id' => $original->getUser()->getId()]));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchByPatternAction(Request $request)
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->searchByPattern($request->query->get('term'));

        $serializer = $this->get('serializer');
        $json = $serializer->serialize($recipes, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @return Response
     */
    public function randomAction()
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->fetchRandom();

        $serializer = $this->get('serializer');
        $json = $serializer->serialize($recipes, 'json');

        return new Response($json);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function widgetizeAction(Request $request, $id)
    {
        $recipe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find($id);

        return $this->render('@App/Recipe/widgets/shoppinglist-recipe-simple.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}

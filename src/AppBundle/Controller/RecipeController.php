<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeIngredient;
use AppBundle\Form\Type\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

                $this->get('session')->getFlashBag()->add('success', 'Votre recette a été enregistrée.');

                return $this->redirect($this->generateUrl('app.recipe.my'));
            }
        }

        return $this->render('@App/Recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $recipe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find($id);

        $form = $this->createForm(RecipeType::class, $recipe);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add('success', 'Votre recette a été mise à jour.');

                return $this->redirect($this->generateUrl('app.recipe.my'));
            }
        }

        return $this->render('@App/Recipe/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction(Request $request, $id)
    {
        $recipe = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->find($id);

        return $this->render('@App/Recipe/read.html.twig', [
            'recipe' => $recipe,
        ]);
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

        return $this->render('@App/Recipe/widgets/recipe-simple.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Form\Type\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->findAll();

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

        return $this->render('AppBundle:Recipe:index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $recipe->setUser($this->getUser());

                $this->getDoctrine()->getManager()->persist($recipe);
                $this->getDoctrine()->getManager()->flush();

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
     * @return Response
     */
    public function searchByPatternAction(Request $request)
    {
        $recipes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Recipe')->searchByPattern($request->query->get('q'));

        $response = [
            'total_count' => count($recipes),
            'items' => $recipes,
        ];

        $serializer = $this->get('serializer');
        $json = $serializer->serialize($response, 'json');

        return new Response($json);
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
}

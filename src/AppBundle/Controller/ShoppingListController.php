<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\ShoppingList;
use AppBundle\Form\Type\RecipeSearchType;
use AppBundle\Form\Type\ShoppingListType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShoppingListController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $shoppingLists = $this->getDoctrine()->getRepository("AppBundle:ShoppingList")->findBy(['user' => $this->getUser()]);

        return $this->render('AppBundle:ShoppingList:index.html.twig', [
            'shoppingLists' => $shoppingLists,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction(Request $request, $id)
    {
        $shoppingList = $this->getDoctrine()->getRepository("AppBundle:ShoppingList")->find($id);

        return $this->render('@App/ShoppingList/read.html.twig', [
            'shoppingList' => $shoppingList,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $shoppingList = new ShoppingList();

        /**
         * todo: to remove
         */
//        $recipe = $this->getDoctrine()->getRepository("AppBundle:Recipe")->find(1);
//        $shoppingListRecipe = new ShoppingListRecipe();
//        $shoppingListRecipe->setRecipe($recipe);
//        $shoppingList->addRecipe($shoppingListRecipe);

        $shoppingList
            ->setUser($this->getUser())
        ;

        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $searchForm = $this->createForm(RecipeSearchType::class, $recipe = new Recipe());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($shoppingList);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add('success', 'Votre liste de courses a été enregistrée.');

                return $this->redirect($this->generateUrl('app.shopping_list'));
            }
        }

        return $this->render('AppBundle:ShoppingList:create.html.twig', [
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $shoppingList = $this->getDoctrine()->getRepository("AppBundle:ShoppingList")->find($id);

        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $searchForm = $this->createForm(RecipeSearchType::class, $recipe = new Recipe());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($shoppingList);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add('success', 'Votre liste de courses a été modifiée.');

                return $this->redirect($this->generateUrl('app.shopping_list'));
            }
        }

        return $this->render('AppBundle:ShoppingList:create.html.twig', [
            'form' => $form->createView(),
            'searchForm' => $searchForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addRecipeAction(Request $request)
    {
        $shoppingList = new ShoppingList();

        $form = $this->createForm(ShoppingListType::class, $shoppingList);

        /**
         * todo: impossible autrement ?
         */
        $recipe = [
            "recipe" => $request->request->get('id'),
        ];

        $req = $request->request->get($form->getName(), []);
        if (!isset($req["recipes"])) {
            $req["recipes"] = [];
        }
        array_push($req["recipes"], $recipe);
        $request->request->set($form->getName(), $req);

        $form->submit($request->request->get($form->getName()));

        return $this->render('@App/ShoppingList/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

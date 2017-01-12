<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeIngredient;
use AppBundle\Form\Type\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IngredientController
 * @package Van\RecipeBundle\Controller
 */
class IngredientController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchByPatternAction(Request $request)
    {
        $ingredients = $this->getDoctrine()->getManager()->getRepository('AppBundle:Ingredient')->searchByPattern($request->query->get('term'));

        $serializer = $this->get('serializer');
        $json = $serializer->serialize($ingredients, 'json');

        return new JsonResponse($json, 200, [], true);
    }
}

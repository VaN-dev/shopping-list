<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resolveSpeechAction(Request $request)
    {
        $query = $request->query->get("q");

        $client = $this->get('app.api.client');
        $result = $client->query($query);

        if(!empty($result->result) && !empty($result->result->action)){
            switch ($result->result->action) {
                case 'smalltalk.greetings.hello':
                    $response = [
                        'success' => true,
                        'action' => 'smalltalk',
                        'speech' => $result->result->fulfillment->speech,
                        'params' => null,
                    ];
                    break;

                case 'redirect':
                    $params = (array) $result->result->parameters;
                    unset($params['route']);
                    $target = str_replace(" ", "", $this->generateUrl($result->result->parameters->route, $params));
                    $response = [
                        'success' => true,
                        'action' => 'Redirection vers ' . $target,
                        'speech' => null,
                        'params' => [
                            'action' => $result->result->action,
                            'value' => $target,
                        ],
                    ];

                    $this->addFlash('speech', $result->result->fulfillment->speech);
                    break;

                case 'suggest-recipes':
                    $response = [
                        'success' => true,
                        'action' => $result->result->action,
                        'speech' => $result->result->fulfillment->speech,
                        'params' => null,
                    ];
                    break;

                case 'recipe.choose':
                    $response = [
                        'success' => true,
                        'action' => $result->result->action,
                        'speech' => $result->result->fulfillment->speech,
                        'params' => $result->result->parameters,
                    ];
                    break;

                default:
                    $response = [
                        'success' => false,
                        'action' => 'Action non-reconnue',
                        'speech' => 'Action non reconnue',
                        'params' => null,
                    ];
                    break;
            }
        } else {
            $response = [
                'success' => false,
                'action' => 'Réponse illisible',
                'speech' => 'Réponse illisible',
                'params' => null,
            ];
        }

        return new JsonResponse($response);
    }

    /**
     *
     */
    public function updateRecipesAction()
    {
        $client = $this->get("app.api.client");

        $recipes = $this->getDoctrine()->getRepository("AppBundle:Recipe")->findAll();

        $response = $client->updateRecipes($recipes);

        dump($response);
        die();
    }
}

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
//        $client = new \GuzzleHttp\Client();
//
//        $query = $_POST['query']; //the users query
//
//        $send = [
//            'headers' => [
//                'Content-Type' => 'application/json;charset=utf-8',
//                'Authorization' => 'Bearer '.$client_access_token
//            ],
//            'body' => json_encode([
//                'query' => $query,
//                'lang' => 'en',
//            ])
//        ];
//
//        try {
//            $response = $client->post('https://api.api.ai/v1/query?v=20150910', $send);
//            $result = json_decode($response->getBody(),true);
//
//            dump($result);
//            die();
//        } catch (\Exception $e) {
//            dump($e->getMessage());
//            die();
//        }

        $query = $request->query->get("q");

        $client = $this->get('app.api.client');
        $result = $client->query($query);

//        dump($result);
//        die();



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

                    $request->getSession()->getFlashBag()->add('speech', $result->result->fulfillment->speech);
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

            return new JsonResponse($response);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createUserEntityAction()
    {
        $client = $this->get("app.api.client");

        $response = $client->createUserEntity();

        dump($response);
        die();
    }
}

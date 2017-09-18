<?php

namespace AppBundle\Service\ApiClient;

use AppBundle\Entity\Recipe;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class ApiClient
 * @package AppBundle\Service\ApiClient
 */
class ApiClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var string
     */
    private $base_uri = "https://api.api.ai/v1";

    /**
     * @var string
     */
    private $client_access_token;

    /**
     * @var string
     */
    private $developer_access_token;

    /**
     * @var int
     */
    private $version = 20150910;

    /**
     * @var string
     */
    private $lang = "fr";

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $body = [];

    /**
     * ApiClient constructor.
     * @param SessionInterface $session
     * @param string $client_access_token
     * @param string $developer_access_token
     */
    public function __construct(SessionInterface $session, string $client_access_token, string $developer_access_token)
    {
        $this->session = $session;
        $this->client = new Client([
            "base_uri" => $this->base_uri,
        ]);

        $this->client_access_token = $client_access_token;
        $this->developer_access_token = $developer_access_token;

        $this->headers = [
            "Authorization" => "Bearer " . $this->client_access_token,
            "Content-type" => "application/json;charset=UTF-8",
            'Accept' => 'application/json',
        ];

        $this->body = [
            "sessionId" => $this->session->getId(),
            "lang" => $this->lang,
        ];
    }

    /**
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        $body = $this->body;
        $body["query"] = $query;

        $request = [
            "headers" => $this->headers,
            "json" => $body,
        ];

        $response = json_decode((string) $this->client->request("POST", $this->base_uri . "/query/?v=" . $this->version, $request)->getBody());

        return $response;
    }

    /**
     * @param $recipes
     * @return mixed
     */
    public function updateRecipes($recipes)
    {
        $body = $this->body;
        $entries = [];

        /**
         * @var Recipe[] $recipes
         */
        foreach ($recipes as $recipe) {
            $entries[] = [
                "value" => $recipe->getName(),
                "synonyms" => [],
            ];
        }

        $headers["Authorization"] = "Bearer " . $this->developer_access_token;

        $body = [
            "name" => "recipe",
            "entries" => $entries,
        ];

        $request = [
            "headers" => $this->headers,
            "json" => $body,
        ];

        $response = json_decode((string) $this->client->request("PUT", $this->base_uri . "/entities/" . $body["name"] . "?v=" . $this->version, $request)->getBody());

        return $response;
    }

    public function createUserEntity()
    {
        $body = [
//            "sessionId" => $this->session->getId(),
            "sessionId" => 12345,
            "entities" => [
                [
                    "name" => "recipe",
                    "entries" => [
                        [
                            "value" => "Tonkatsu",
                            "synonyms" => [
                                "Tonkatsu",
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $json = json_encode($body);

        $headers = [
            "Authorization" => "Bearer " . $this->developer_access_token,
            "Content-type" => "application/json;charset=UTF-8",
            'Accept' => 'application/json',
        ];

//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $this->base_uri . "/userEntities/?v=" . $this->version,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => $json,
//            CURLOPT_HTTPHEADER => array(
//                "authorization: Bearer " . $this->developer_access_token,
//                "content-type: application/json;charset=utf-8",
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }


        echo '<pre>';
        $response = $this->client->post($this->base_uri . '/userEntities?v=' . $this->version, [
            'headers'       => $headers,
            'form_params'   => $body,
            'debug'         => true,
        ]);
        echo '</pre>';
        dump(json_decode($response->getBody(), true));

        die();




//
//        $headers = [
//            "authorization" => "Bearer " . $this->developer_access_token,
//            "content-type" => "application/json;charset=utf-8",
//        ];
//
//        $request = [
//            "headers" => $headers,
//            "form_params" => $body,
//        ];
//
//        $response = $this->client->request("POST", $this->base_uri . "/userEntities/?v=" . $this->version, $request);
//
//        dump($response->getStatusCode());
//
//        dump((string) $response->getBody());
//
////        $request = new Request("POST", $this->base_uri . "/userEntities?v=" . $this->version, $headers, $json);
////        $response = $this->client->send($request);
//
//        die();
//
//        return "ok";
    }

    public function curl()
    {

//        $request = new Request("POST", $this->base_uri . "/userEntities?v=" . $this->version, $headers, $json);
//        $response = $this->client->send($request);

//        foreach ($headers as $k => $header) {
//            $headers[] = $k . ": " . $header;
//            unset($headers[$k]);
//        }
//
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $this->base_uri . "/query?v=" . $this->version,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => json_encode($body),
//            CURLOPT_HTTPHEADER => $headers,
//            CURLOPT_RETURNTRANSFER => true,
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//            die();
//        }
//
//        return json_decode($response);
    }
}
<?php

namespace AppBundle\Service\ApiClient;

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
            "verify" => false,
        ]);

        $this->client_access_token = $client_access_token;
        $this->developer_access_token = $developer_access_token;
    }

    public function createUserEntity()
    {
        $body = [
            "sessionId" => $this->session->getId(),
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_uri . "/userEntities/?v=" . $this->version,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->developer_access_token,
                "content-type: application/json;charset=utf-8",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

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
}
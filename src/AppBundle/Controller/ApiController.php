<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ApiController
 * @package AppBundle\Controller
 */
class ApiController extends Controller
{
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

<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/Default/index.html.twig');
    }
}

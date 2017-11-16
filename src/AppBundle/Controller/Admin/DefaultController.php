<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller\Admin
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@App/Admin/index.html.twig');
    }
}
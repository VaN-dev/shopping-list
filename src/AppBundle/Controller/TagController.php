<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TagController
 * @package Van\RecipeBundle\Controller
 */
class TagController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->findAll();

        return $this->render('@App/Tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction($name)
    {
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->findOneBy(['name' => $name]);

        return $this->render('@App/Tag/read.html.twig', [
            'tag' => $tag,
        ]);
    }
}
<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Config;
use AppBundle\Form\Type\ConfigType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfigController
 * @package AppBundle\Controller\Admin
 */
class ConfigController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $config = $em->getRepository("AppBundle:Config")->find(1);

        if (null === $config) {
            $config = new Config();
            $em->persist($config);
        }

        $form = $this->createForm(ConfigType::class, $config);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();
            } else {
                $this->addFlash('danger', 'Un problème est survenu lors de la modification de la config.');
            }
        }

        return $this->render('@App/Admin/Config/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
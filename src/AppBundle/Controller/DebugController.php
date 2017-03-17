<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DebugController
 * @package AppBundle\Controller
 */
class DebugController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailInvitationAction()
    {
        $recipes = $this->getDoctrine()->getRepository('AppBundle:Recipe')->fetchLatest(3);

        $html = $this->render('@App/Friend/mails/invitation.html.twig', [
            'recipes' => $recipes,
        ]);

        return $html;
    }
}

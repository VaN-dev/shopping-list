<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Password encoding
                $passwordEncoding = $this->get('app.security.encoder.password');
                $user->setPassword($passwordEncoding->encodePassword($user->getPassword(), $user->getSalt()));
                $user->setRoles(["FRONTEND_USER"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', '<strong>Well done!</strong> You successfully registered.');
                return $this->redirect($this->generateUrl('index'));
            } else {
                dump((string) $form->getErrors());
                die();
            }
        }
        return $this->render('AppBundle:User:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction()
    {
        return $this->render('AppBundle:User:profile.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailsAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);
        $recipes = $this->getDoctrine()->getRepository("AppBundle:Recipe")->findBy(['user' => $user]);

        return $this->render('AppBundle:User:details.html.twig', [
            'user' => $user,
            'recipes' => $recipes,
        ]);
    }
}

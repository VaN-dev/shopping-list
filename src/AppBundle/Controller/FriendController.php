<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Friendship;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FriendController
 * @package AppBundle\Controller
 */
class FriendController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $friends = $this->getDoctrine()->getRepository('AppBundle:User')->getFriends($this->getUser());
        $friend_requests = $this->getDoctrine()->getRepository('AppBundle:Friendship')->findBy(['receiver' => $this->getUser(), 'status' => Friendship::STATUS_WAITING]);

        return $this->render('AppBundle:Friend:my.html.twig', [
            'friends' => $friends,
            'friend_requests' => $friend_requests,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function friendRequestAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $receiver = $em->getRepository('AppBundle:User')->find($id);

        if ($receiver === $this->getUser()) {
            $request->getSession()->getFlashBag()->add('danger', 'Vous ne pouvez pas être ami avec vous-même...');
        } else {
            $friendship = new Friendship();
            $friendship
                ->setSender($this->getUser())
                ->setReceiver($receiver)
            ;

            $em->persist($friendship);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Invitation envoyée.');
        }

        return new RedirectResponse($this->generateUrl('app.user.friends'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function acceptFriendRequestAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $friendship = $em->getRepository('AppBundle:Friendship')->find($id);

        $friendship->accept();

        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Demande acceptée.');

        return new RedirectResponse($this->generateUrl('app.user.friends'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function cancelFriendRequestAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $friend = $em->getRepository('AppBundle:User')->find($id);

        $friendship = $em->getRepository('AppBundle:Friendship')->findActiveFromFriend($this->getUser(), $friend);

        $friendship->cancel();

        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Ami supprimé.');

        return new RedirectResponse($this->generateUrl('app.user.friends'));
    }
}

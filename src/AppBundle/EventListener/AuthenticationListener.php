<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class AuthenticationListener
 * @package AppBundle\EventListener
 */
class AuthenticationListener
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * AuthenticationListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     */
    public function __construct(TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * onAuthenticationSuccess
     *
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /**
         * @var User $user
         */
        $user = $this->tokenStorage->getToken()->getUser();

        if (false === $user->isProfileCompleted()) {
            $this->session->set('app/profile-completion', true);
        }
    }
}
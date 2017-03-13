<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user_01 = new User();

        $user_01->setPassword('1234');

        $encoder = $this->container->get('app.security.encoder.password');
        $password = $encoder->encodePassword($user_01->getPassword(), $user_01->getSalt());
        $user_01->setPassword($password);

        $user_01
            ->setUsername('VaN')
            ->setEmail('fanel.dev@gmail.com')
        ;
        $manager->persist($user_01);

        $manager->flush();
    }
}
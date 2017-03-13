<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Scope;

/**
 * Class LoadScopeData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadScopeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $scope_01 = new Scope();
        $scope_01
            ->setName('Publique')
            ->setSlug('public')
        ;
        $manager->persist($scope_01);

        $scope_02 = new Scope();
        $scope_02
            ->setName('Amis seulement')
            ->setSlug('friends-only')
        ;
        $manager->persist($scope_02);

        $scope_03 = new Scope();
        $scope_03
            ->setName('Privée')
            ->setSlug('private')
        ;
        $manager->persist($scope_03);

        $manager->flush();
    }
}
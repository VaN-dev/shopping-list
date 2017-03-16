<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Unit;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUnitData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUnitData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $scope_01 = new Unit();
        $scope_01
            ->setName('gramme')
            ->setSlug('gramme')
        ;
        $manager->persist($scope_01);

        $scope_02 = new Unit();
        $scope_02
            ->setName('centilitre')
            ->setSlug('centilitre')
        ;
        $manager->persist($scope_02);

        $scope_03 = new Unit();
        $scope_03
            ->setName('pièce')
            ->setSlug('piece')
        ;
        $manager->persist($scope_03);

        $manager->flush();
    }
}
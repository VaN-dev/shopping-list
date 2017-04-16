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

        $scope_04 = new Unit();
        $scope_04
            ->setName('boîte')
            ->setSlug('boite')
        ;
        $manager->persist($scope_04);

        $scope_05 = new Unit();
        $scope_05
            ->setName('cuillère à soupe')
            ->setSlug('cuillere-a-soupe')
        ;
        $manager->persist($scope_05);

        $scope_06 = new Unit();
        $scope_06
            ->setName('cuillère à café')
            ->setSlug('cuillere-a-cafe')
        ;
        $manager->persist($scope_06);

        $scope_07 = new Unit();
        $scope_07
            ->setName('sachet')
            ->setSlug('sachet')
        ;
        $manager->persist($scope_07);

        $scope_08 = new Unit();
        $scope_08
            ->setName('tranche')
            ->setSlug('tranche')
        ;
        $manager->persist($scope_08);

        $manager->flush();
    }
}
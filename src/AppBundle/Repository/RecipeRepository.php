<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends EntityRepository
{
    /**
     * @param $pattern
     * @return array
     */
    public function searchByPattern($pattern)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.name LIKE :pattern')
            ->setParameter('pattern', '%'.$pattern.'%')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param int $nb
     * @return array
     */
    public function fetchRandom($nb = 3)
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($nb)
        ;

        return $qb->getQuery()->getResult();
    }
}

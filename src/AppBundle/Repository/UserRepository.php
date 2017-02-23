<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Friendship;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return array
     */
    public function getFriends(User $user)
    {
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('AppBundle:Friendship', 'f1', 'WITH', 'f1.sender = u')
            ->leftJoin('AppBundle:Friendship', 'f2', 'WITH', 'f2.receiver = u')
            ->andWhere('f1.receiver = :user OR f2.sender = :user')
            ->andWhere('f1.status = :status_active OR f2.status = :status_active')
            ->setParameter('user', $user)
            ->setParameter('status_active', Friendship::STATUS_ACTIVE)
        ;

        return $qb->getQuery()->getResult();
    }
}

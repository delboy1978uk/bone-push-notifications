<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Repository;

use Bone\Notification\PushToken\Entity\PushToken;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;

class PushTokenRepository extends EntityRepository
{
    /**
     * @param int $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     * @return PushToken
     * @throws \Doctrine\ORM\ORMException
     */
    public function find($id, $lockMode = null, $lockVersion = null): PushToken
    {
        /** @var PushToken $pushToken */
        $pushToken =  parent::find($id, $lockMode, $lockVersion);

        if (!$pushToken) {
            throw new EntityNotFoundException('PushToken not found.', 404);
        }

        return $pushToken;
    }

    /**
     * @param PushToken $pushToken
     * @return $pushToken
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(PushToken $pushToken): PushToken
    {
        if(!$pushToken->getID()) {
            $this->_em->persist($pushToken);
        }

        $this->_em->flush($pushToken);

        return $pushToken;
    }

    /**
     * @param PushToken $pushToken
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(PushToken $pushToken): void
    {
        $this->_em->remove($pushToken);
        $this->_em->flush($pushToken);
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalPushTokenCount(): int
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('count(p.id)');
        $query = $qb->getQuery();

        return (int) $query->getSingleScalarResult();
    }
}

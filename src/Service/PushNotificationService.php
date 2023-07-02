<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Service;

use Bone\Notification\PushToken\Entity\PushToken;
use Bone\Notification\PushToken\Repository\PushTokenRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class PushNotificationService
{
    /** @var EntityManager $em */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param array $data
     * @return PushToken
     */
    public function createFromArray(array $data): PushToken
    {
        $pushToken = new PushToken();

        return $this->updateFromArray($pushToken, $data);
    }

    /**
     * @param PushToken $pushToken
     * @param array $data
     * @return PushToken
     */
    public function updateFromArray(PushToken $pushToken, array $data): PushToken
    {
        isset($data['id']) ? $pushToken->setId($data['id']) : null;
        isset($data['token']) ? $pushToken->setToken($data['token']) : $pushToken->setToken('');

        return $pushToken;
    }

    /**
     * @param PushToken $pushToken
     * @return PushToken
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function savePushToken(PushToken $pushToken): PushToken
    {
        return $this->getRepository()->save($pushToken);
    }

    /**
     * @param PushToken $pushToken
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deletePushToken(PushToken $pushToken): void
    {
        $this->getRepository()->delete($pushToken);
    }

    /**
     * @return PushTokenRepository
     */
    public function getRepository(): PushTokenRepository
    {
        /** @var PushTokenRepository $repository */
        $repository = $this->em->getRepository(PushToken::class);

        return $repository;
    }
}

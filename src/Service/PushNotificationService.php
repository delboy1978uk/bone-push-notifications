<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Service;

use Bone\Notification\PushToken\Entity\PushToken;
use Bone\Notification\PushToken\Repository\PushTokenRepository;
use DateTime;
use Del\Entity\User;
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

    public function registerPushToken(User $user, string $token): void
    {

    }

    public function sendNotification(string $token, string $message, array $data = []): void
    {
        $this->em->getRepository(PushToken::class)->findOneBy(['token' => $token]);
    }
}

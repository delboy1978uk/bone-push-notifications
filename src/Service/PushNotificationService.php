<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Service;

use Bone\Notification\PushToken\Entity\PushToken;
use Bone\Notification\PushToken\Exception\PushTokenFoundException;
use Bone\Notification\PushToken\Exception\PushTokenNotFoundException;
use Del\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PushNotificationService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /***
     * @throws PushTokenFoundException
     */
    public function registerPushToken(User $user, string $token): void
    {
        $pushToken = $this->em->getRepository(PushToken::class)->findOneBy(['token' => $token, 'user' => $user]);

        if ($pushToken) {
            throw new PushTokenFoundException();
        }

        $pushToken = new PushToken();
        $pushToken->setToken($token);
        $pushToken->setUser($user);
        $this->em->persist($pushToken);
        $this->em->flush();
    }

    public function sendNotification(User $user, string $message, array $data = []): void
    {
        $tokens = $this->em->getRepository(PushToken::class)->findBy(['user' => $user]);
    }
}

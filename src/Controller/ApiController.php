<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Controller;

use Bone\Notification\PushToken\Exception\PushTokenFoundException;
use Bone\Notification\PushToken\Exception\PushTokenNotFoundException;
use Bone\Notification\PushToken\Service\PushNotificationService;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiController
{
    private PushNotificationService $service;
    private array $settings;

    public function __construct(PushNotificationService $service, array $boneNativeSettings)
    {
        $this->service = $service;
        $this->settings = $boneNativeSettings;
    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $request->getAttribute('user');
            $body = $request->getParsedBody();
            $this->service->registerPushToken($user, $body['token']);
            $responseData = [
                'status' => 201,
                'success' => true,
            ];
        } catch (PushTokenFoundException $e) {
            $responseData = [
                'status' => 200,
                'success' => true,
            ];
        } catch (Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return new JsonResponse($responseData, $responseData['status']);
    }

    public function send(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $request->getAttribute('user');
            $body = $request->getParsedBody();
            $this->service->sendNotification($user, $body['message']);
            $responseData = [
                'status' => 200,
                'success' => true,
            ];
        } catch (Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return new JsonResponse($responseData, $responseData['status']);
    }

    public function wellKnownAppleApp(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->getWellKnownData('iOS'));
    }

    public function wellKnownAndroidApp(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->getWellKnownData('android'));
    }

    private function getWellKnownData(string $platform): array
    {
        if (isset($this->settings['wellKnown']) && isset($this->settings['wellKnown'][$platform])) {
            return $this->settings['wellKnown'][$platform];
        }

        return [];
    }
}

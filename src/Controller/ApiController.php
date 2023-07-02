<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Controller;

use Bone\Notification\PushToken\Collection\PushTokenCollection;
use Bone\Notification\PushToken\Form\PushTokenForm;
use Bone\Notification\PushToken\Service\PushNotificationService;
use Bone\Notification\PushToken\Service\PushTokenService;
use Laminas\Diactoros\Response\JsonResponse;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiController
{
    private PushNotificationService $service;

    public function __construct(PushNotificationService $service)
    {
        $this->service = $service;
    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $user = $request->getAttribute('user');
            $body = $request->getParsedBody();
            $this->service->registerPushToken($user, $body['token']);
            $responseData = [
                'status' => 200,
                'success' => true
            ];
        } catch (\Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => true
            ];
        }

        return new JsonResponse($responseData, $responseData['status']);
    }

    public function send(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $this->service->sendNotification($body['token'], $body['message']);
            $responseData = [
                'status' => 200,
                'success' => true
            ];
        } catch (\Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => true
            ];
        }

        return new JsonResponse($responseData, $responseData['status']);
    }
}

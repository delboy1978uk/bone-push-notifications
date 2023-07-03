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
                'status' => 201,
                'success' => true,
            ];
        } catch (PushTokenFoundException $e) {
            $responseData = [
                'status' => 200,
                'success' => true
            ];
        } catch (Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => false,
                'error' => $e->getMessage()
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
                'success' => true
            ];
        } catch (Exception $e) {
            $responseData = [
                'status' => 500,
                'success' => false,
                'error' => $e->getMessage()
            ];
        }

        return new JsonResponse($responseData, $responseData['status']);
    }
}

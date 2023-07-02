<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Controller;

use Bone\Notification\PushToken\Collection\PushTokenCollection;
use Bone\Notification\PushToken\Form\PushTokenForm;
use Bone\Notification\PushToken\Service\PushTokenService;
use Laminas\Diactoros\Response\JsonResponse;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiController
{
    /** @param PushTokenService $service */
    private $service;

    /**
     * @param PushTokenService $service
     */
    public function __construct(PushTokenService $service)
    {
        $this->service = $service;
    }
}

<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Http\Middleware\HalCollection;
use Bone\Http\Middleware\JsonParse;
use Bone\Notification\PushToken\Controller\ApiController;
use Bone\Notification\PushToken\Service\PushNotificationService;
use Bone\OAuth2\Http\Middleware\ResourceServerMiddleware;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class PushNotificationPackage implements RegistrationInterface, RouterConfigInterface, EntityRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[PushNotificationService::class] = $c->factory(function (Container $c) {
            $em =  $c->get(EntityManagerInterface::class);

            return new PushNotificationService($em);
        });

        $c[ApiController::class] = $c->factory(function (Container $c) {
            $service = $c->get(PushNotificationService::class);

            return new ApiController($service);
        });
    }

    public function getEntityPath(): string
    {
        return __DIR__ . '/Entity';
    }

    public function addRoutes(Container $c, Router $router): Router
    {
        $auth = $c->get(ResourceServerMiddleware::class);
        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api/notifications', function (RouteGroup $route) {
            $route->map('POST', '/register-token', [ApiController::class, 'register'])->prependMiddleware(new HalCollection(5));
            $route->map('POST', '/send-notification', [ApiController::class, 'send']);
        })
        ->middlewares([$auth, new JsonParse()])
        ->setStrategy($strategy);

        return $router;
    }
}

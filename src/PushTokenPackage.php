<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken;

use Barnacle\Container;
use Barnacle\EntityRegistrationInterface;
use Barnacle\RegistrationInterface;
use Bone\Http\Middleware\HalCollection;
use Bone\Notification\PushToken\Controller\ApiController;
use Bone\Notification\PushToken\Service\PushTokenService;
use Bone\Router\Router;
use Bone\Router\RouterConfigInterface;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Strategy\JsonStrategy;

class PushTokenPackage implements RegistrationInterface, RouterConfigInterface, EntityRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[PushTokenService::class] = $c->factory(function (Container $c) {
            $em =  $c->get(EntityManager::class);

            return new PushTokenService($em);
        });

        $c[PushTokenApiController::class] = $c->factory(function (Container $c) {
            $service = $c->get(PushTokenService::class);

            return new ApiController($service);
        });
    }

    public function addViewExtensions(Container $c): array
    {
        return [];
    }

    public function getEntityPath(): string
    {
        return __DIR__ . '/Entity';
    }

    public function addRoutes(Container $c, Router $router): Router
    {
        $factory = new ResponseFactory();
        $strategy = new JsonStrategy($factory);
        $strategy->setContainer($c);

        $router->group('/api/notifications', function (RouteGroup $route) {
            $route->map('POST', '/register-token', [ApiController::class, 'index'])->prependMiddleware(new HalCollection(5));
            $route->map('POST', '/send-notification', [ApiController::class, 'create']);
        })
        ->setStrategy($strategy);

        return $router;
    }
}

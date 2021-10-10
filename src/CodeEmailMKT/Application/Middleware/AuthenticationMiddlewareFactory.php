<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
	 	$router = $container->get(RouterInterface::class);
        $auth = $container->get(AuthInterface::class);
        return new AuthenticationMiddleware($router,$auth);
    }
}

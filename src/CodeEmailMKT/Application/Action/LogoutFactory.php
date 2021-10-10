<?php

namespace CodeEmailMKT\Application\Action;

use CodeEmailMKT\Domain\Service\AuthInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;

class LogoutFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $authService = $container->get(AuthInterface::class);
        return new LogoutAction($router, $authService);
    }
}

<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Interop\Container\ContainerInterface;
use CodeEmailMKT\Infrastructure\Bootstrap;

class BootstrapMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
	 	$bootstrap = new Bootstrap;
        $flash = $container->get(FlashMessageInterface::class);
        return new BootstrapMiddleware($bootstrap, $flash);
    }
}

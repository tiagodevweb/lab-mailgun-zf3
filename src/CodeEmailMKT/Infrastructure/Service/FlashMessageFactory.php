<?php

namespace CodeEmailMKT\Infrastructure\Service;

use Aura\Session\Session;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class FlashMessageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var FlashMessenger $flashMessenger */
        $flashMessenger = new FlashMessenger();
        return new FlashMessage($flashMessenger);
    }
}
<?php

namespace CodeEmailMKT\Application\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Doctrine\ORM\EntityManager;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class TestePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //$router   = $container->get(RouterInterface::class);
        $template = ($container->has(TemplateRendererInterface::class))
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new TestePageAction($container->get(CustomerRepositoryInterface::class), $template);
    }
}

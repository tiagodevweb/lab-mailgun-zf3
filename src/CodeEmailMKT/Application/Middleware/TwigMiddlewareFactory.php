<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Infrastructure\View\Twig\TwigRenderer;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\View\HelperPluginManager;

class TwigMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var TwigRenderer $twigRenderer
         */
        $twigRenderer = $container->get(TemplateRendererInterface::class);
        $twigEnv = $twigRenderer->getTemplate();
        $helperManager = $container->get(HelperPluginManager::class);
        return new TwigMiddleware($twigEnv, $helperManager);
    }
}

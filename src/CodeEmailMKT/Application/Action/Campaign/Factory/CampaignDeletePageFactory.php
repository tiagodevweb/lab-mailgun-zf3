<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignDeletePageAction;
use CodeEmailMKT\Application\Form\CampaignForm;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignDeletePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CampaignRepositoryInterface::class);
        $router = $container->get(RouterInterface::class);
        $form = $container->get(CampaignForm::class);
        $mailgun = $container->get(Mailgun::class);
        $mailgunConfig = $container->get('config')['mailgun'];

        return new CampaignDeletePageAction($repository, $template, $router, $form, $mailgun, $mailgunConfig);
    }
}

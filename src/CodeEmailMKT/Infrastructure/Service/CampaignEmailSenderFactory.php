<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSenderFactory
{
    public function __invoke(ContainerInterface $container): CampaignEmailSender
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailgun = $container->get(Mailgun::class);
        $mailgunConfig = $container->get('config')['mailgun'];
        $customerRepository = $container->get(CustomerRepositoryInterface::class);

        return new CampaignEmailSender($template,$mailgun,$mailgunConfig, $customerRepository);
    }
}
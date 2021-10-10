<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReportFactory
{
    public function __invoke(ContainerInterface $container): CampaignReport
    {
        $template = $container->get(TemplateRendererInterface::class);
        $mailgun = $container->get(Mailgun::class);
        $mailgunConfig = $container->get('config')['mailgun'];
        $customerRepository = $container->get(CustomerRepositoryInterface::class);

        return new CampaignReport($template,$mailgun,$mailgunConfig, $customerRepository);
    }
}
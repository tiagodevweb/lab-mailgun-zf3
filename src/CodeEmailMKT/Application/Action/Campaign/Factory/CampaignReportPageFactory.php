<?php

namespace CodeEmailMKT\Application\Action\Campaign\Factory;

use CodeEmailMKT\Application\Action\Campaign\CampaignReportPageAction;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Interop\Container\ContainerInterface;

class CampaignReportPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $repository = $container->get(CampaignRepositoryInterface::class);
        $report = $container->get(CampaignReportInterface::class);

        return new CampaignReportPageAction($repository, $report);
    }
}

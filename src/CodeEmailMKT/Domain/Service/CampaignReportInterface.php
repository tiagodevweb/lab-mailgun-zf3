<?php

namespace CodeEmailMKT\Domain\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Infrastructure\Service\CampaignReport;
use Psr\Http\Message\ResponseInterface;

interface CampaignReportInterface
{
	public function setCampaign(Campaign $campaign): CampaignReport;

    public function render(): ResponseInterface;
}
<?php

namespace CodeEmailMKT\Domain\Service;

use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Infrastructure\Service\CampaignEmailSender;

interface CampaignEmailSenderInterface extends EmailInterface
{
	public function setCampaign(Campaign $campaign): CampaignEmailSender;
}
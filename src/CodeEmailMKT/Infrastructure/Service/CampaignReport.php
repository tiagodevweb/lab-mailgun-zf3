<?php
declare(strict_types=1);

namespace CodeEmailMKT\Infrastructure\Service;


use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignReport implements CampaignReportInterface
{
    /**
     * @var Campaign
     */
    protected $campaign;
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;
    /**
     * @var array
     */
    private $mailgunConfig;
    /**
     * @var Mailgun
     */
    private $mailgun;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CampaignEmailSender constructor.
     * @param TemplateRendererInterface $templateRenderer
     * @param Mailgun $mailgun
     * @param array $mailgunConfig
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(TemplateRendererInterface $templateRenderer, Mailgun $mailgun, array $mailgunConfig, CustomerRepositoryInterface $customerRepository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->mailgun = $mailgun;
        $this->mailgunConfig = $mailgunConfig;
        $this->customerRepository = $customerRepository;
    }


    /**
     * @param Campaign $campaign
     * @return CampaignReport
     */
    public function setCampaign(Campaign $campaign): CampaignReport
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function render(): ResponseInterface
    {
        return new HtmlResponse($this->templateRenderer->render('app::campaign/report',[
            'campaign_data' => $this->getCampaignData(),
            'campaign' => $this->campaign,
            'customers_count' => $this->getCountCustomers(),
            'opened_distinct_count' => $this->getCountOpenedDistinct()
        ]));
    }

    protected function getCampaignData()
    {
        $domain = $this->mailgunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        return $response->http_response_body;
    }

    protected function getCountOpenedDistinct()
    {
        $domain = $this->mailgunConfig['domain'];
        $response = $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}/opens",[
            'groupby' => 'recipient',
            'count' => true
        ]);
        return $response->http_response_body->count;
    }

    protected function getCountCustomers()
    {
        $tags = $this->campaign->getTags()->toArray();
        $customers = $this->customerRepository->findByTags($tags);
        return count($customers);
    }
}
<?php
declare(strict_types=1);

namespace CodeEmailMKT\Infrastructure\Service;


use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Entity\Customer;
use CodeEmailMKT\Domain\Entity\Tag;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Mailgun\Messages\BatchMessage;
use Zend\Expressive\Template\TemplateRendererInterface;

class CampaignEmailSender implements CampaignEmailSenderInterface
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
     * @return CampaignEmailSender
     */
    public function setCampaign(Campaign $campaign): CampaignEmailSender
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function send()
    {
        $this->createCampaign();
        $batchMessage = $this->getBatchMessage();
        $tags = $this->campaign->getTags()->toArray();

        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $batchMessage->addTag($tag->getName());
            $customers = $this->customerRepository->findByTags($tags);
            /** @var Customer $customer */
            foreach ( $customers as $customer ) {
                $name = (!$customer->getName() or $customer->getName() === '')
                        ? $customer->getEmail()
                        : $customer->getName();
                $batchMessage->addToRecipient($customer->getEmail(),['full_name'=>$name]);
            }
        }
        $batchMessage->finalize();
    }

    /**
     * @return BatchMessage
     */
    protected function getBatchMessage(): BatchMessage
    {
        $batchMessage = $this->mailgun->BatchMessage($this->mailgunConfig['domain']);
        $batchMessage->addCampaignId("campaign_{$this->campaign->getId()}");
        $batchMessage->setFromAddress('tiago.desenvolvedorweb@gmail.com',['full_name'=>'Tiago Lopes']);
        $batchMessage->setSubject($this->campaign->getSubject());
        $batchMessage->setHtmlBody($this->getHtmlBody());
        return $batchMessage;
    }

    /**
     * @return string
     */
    protected function getHtmlBody(): string
    {
        $content = $this->campaign->getTemplate();
        return $this->templateRenderer->render('app::campaign/email_template',['content'=>$content]);
    }

    protected function createCampaign()
    {
        $domain = $this->mailgunConfig['domain'];
        try {
            $this->mailgun->get("$domain/campaigns/campaign_{$this->campaign->getId()}");
        } catch (MissingEndpoint $e) {
            $this->mailgun->post("$domain/campaigns",[
                'id' => "campaign_{$this->campaign->getId()}",
                'name' => $this->campaign->getName()
            ]);
        }
    }
}
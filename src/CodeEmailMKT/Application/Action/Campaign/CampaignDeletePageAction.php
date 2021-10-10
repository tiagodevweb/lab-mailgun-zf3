<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Domain\Entity\Campaign;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Mailgun\Connection\Exceptions\MissingEndpoint;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignDeletePageAction
{
	private $template;

	/**
	 * 
	 * @var CampaignRepositoryInterface
	 */
	private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var CampaignForm
     */
    private $form;
    /**
     * @var Mailgun
     */
    private $mailgun;
    /**
     * @var array
     */
    private $mailgunConfig;

    /**
     * CampaignCreatePageAction constructor.
     * @param CampaignRepositoryInterface $repository
     * @param Template\TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param CampaignForm $form
     * @param Mailgun $mailgun
     * @param array $mailgunConfig
     */
    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form,
        Mailgun $mailgun,
        array $mailgunConfig
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
        $this->mailgun = $mailgun;
        $this->mailgunConfig = $mailgunConfig;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        /** @var Campaign $campaign */
        $campaign = $this->repository->find($request->getAttribute('id'));

        $this->form->bind($campaign);
        $this->form->add(new HttpMethodElement('DELETE'));

        if ( $request->getMethod() == 'DELETE' ) {

            $flash = $request->getAttribute('flash');
            $uri = $this->router->generateUri('campaign.list');

            $this->repository->remove($campaign);

            //remove in mailgun
            try {
                $domain = $this->mailgunConfig['domain'];
                $this->mailgun->delete("$domain/campaigns/campaign_{$campaign->getId()}");
            } catch (MissingEndpoint $e) {
                $flash->setMessage(FlashMessageInterface::SUCCESS, 'Campanha excluda com sucesso no sistema, mas não foi localizada na API MailGun.');
                return new RedirectResponse($uri);
            }
            $flash->setMessage(FlashMessageInterface::SUCCESS, 'Campanha excluda com sucesso.');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::campaign/delete', [
            'form' => $this->form
        ]));
    }
}

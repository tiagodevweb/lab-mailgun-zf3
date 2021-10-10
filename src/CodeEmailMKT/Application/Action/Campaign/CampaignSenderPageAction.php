<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;


class CampaignSenderPageAction
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
     * @var CampaignEmailSenderInterface
     */
    private $campaignEmailSender;

    /**
     * CampaignCreatePageAction constructor.
     * @param CampaignRepositoryInterface $repository
     * @param Template\TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param CampaignForm $form
     * @param CampaignEmailSenderInterface $campaignEmailSender
     */
    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form,
        CampaignEmailSenderInterface $campaignEmailSender
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
        $this->campaignEmailSender = $campaignEmailSender;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaign = $this->repository->find($request->getAttribute('id'));

        $this->form->bind($campaign);

        if ( $request->getMethod() == 'POST' ) {
            $this->campaignEmailSender->setCampaign($campaign);
            $this->campaignEmailSender->send();

            $flash = $request->getAttribute('flash');
            $flash->setMessage(FlashMessageInterface::SUCCESS, 'Campanha editada com sucesso.');
            $uri = $this->router->generateUri('campaign.list');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::campaign/sender', [
            'form' => $this->form
        ]));
    }
}

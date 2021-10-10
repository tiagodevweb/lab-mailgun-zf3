<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;


class CampaignUpdatePageAction
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
     * CampaignCreatePageAction constructor.
     * @param CampaignRepositoryInterface $repository
     * @param Template\TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param CampaignForm $form
     */
    public function __construct(
        CampaignRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        CampaignForm $form
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaign = $this->repository->find($request->getAttribute('id'));

        $this->form->bind($campaign);
        $this->form->add(new HttpMethodElement('PUT'));

        if ( $request->getMethod() == 'PUT' ) {
            $dataRaw = $request->getParsedBody();
            $this->form->setData($dataRaw);

            if ( $this->form->isValid() ) {
                $this->repository->update($this->form->getData());
                $flash = $request->getAttribute('flash');
                $flash->setMessage(FlashMessageInterface::SUCCESS, 'Campanha editada com sucesso.');
                $uri = $this->router->generateUri('campaign.list');
                return new RedirectResponse($uri);
            }

        }

        return new HtmlResponse($this->template->render('app::campaign/update', [
            'form' => $this->form
        ]));
    }
}

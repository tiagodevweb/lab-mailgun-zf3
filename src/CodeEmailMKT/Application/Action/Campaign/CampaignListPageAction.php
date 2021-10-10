<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;

class CampaignListPageAction
{
	private $template;

	/**
	 * 
	 * @var CampaignRepositoryInterface
	 */
	private $repository;

    public function __construct(CampaignRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->repository = $repository;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaigns = $this->repository->findAll();
        $message = $request->getAttribute('flash')->getMessage('success');

        return new HtmlResponse($this->template->render('app::campaign/list', [
            'campaigns' => $campaigns,
            'message' => $message
        ]));
    }
}

<?php

namespace CodeEmailMKT\Application\Action\Campaign;

use CodeEmailMKT\Application\Form\CampaignForm;
use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Domain\Persistence\CampaignRepositoryInterface;
use CodeEmailMKT\Domain\Service\CampaignEmailSenderInterface;
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;


class CampaignReportPageAction
{
	/**
	 * 
	 * @var CampaignRepositoryInterface
	 */
	private $repository;
    /**
     * @var CampaignReportInterface
     */
    private $report;


    /**
     * CampaignReportPageAction constructor.
     * @param CampaignRepositoryInterface $repository
     * @param CampaignReportInterface $report
     */
    public function __construct(CampaignRepositoryInterface $repository, CampaignReportInterface $report)
    {
        $this->repository = $repository;
        $this->report = $report;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $campaign = $this->repository->find($request->getAttribute('id'));
        return $this->report->setCampaign($campaign)->render();
    }
}

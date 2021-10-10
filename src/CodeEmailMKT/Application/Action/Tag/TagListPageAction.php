<?php

namespace CodeEmailMKT\Application\Action\Tag;

use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;


class TagListPageAction
{
	private $template;

	/**
	 * 
	 * @var TagRepositoryInterface
	 */
	private $repository;

    public function __construct(TagRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->repository = $repository;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $tags = $this->repository->findAll();
        $message = $request->getAttribute('flash')->getMessage('success');

        return new HtmlResponse($this->template->render('app::tag/list', [
            'tags' => $tags,
            'message' => $message
        ]));
    }
}

<?php

namespace CodeEmailMKT\Application\Action\Tag;

use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Application\Form\TagForm;
use CodeEmailMKT\Domain\Persistence\TagRepositoryInterface;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;

class TagDeletePageAction
{
	private $template;

	/**
	 * 
	 * @var TagRepositoryInterface
	 */
	private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var TagForm
     */
    private $form;

    /**
     * CustomerCreatePageAction constructor.
     * @param TagRepositoryInterface $repository
     * @param Template\TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param TagForm $form
     */
    public function __construct(
        TagRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        TagForm $form
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $tag = $this->repository->find($request->getAttribute('id'));

        $this->form->bind($tag);
        $this->form->add(new HttpMethodElement('DELETE'));

        if ( $request->getMethod() == 'DELETE' ) {

            $this->repository->remove($tag);

            $flash = $request->getAttribute('flash');
            $flash->setMessage(FlashMessageInterface::SUCCESS, 'Tag excluida com sucesso.');
            $uri = $this->router->generateUri('tag.list');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::tag/delete', [
            'form' => $this->form
        ]));
    }
}

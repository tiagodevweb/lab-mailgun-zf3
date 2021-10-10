<?php

namespace CodeEmailMKT\Application\Action\Customer;

use CodeEmailMKT\Application\Form\CustomerForm;
use CodeEmailMKT\Application\Form\HttpMethodElement;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerDeletePageAction
{
	private $template;

	/**
	 * 
	 * @var CustomerRepositoryInterface
	 */
	private $repository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var CustomerForm
     */
    private $form;

    /**
     * CustomerCreatePageAction constructor.
     * @param CustomerRepositoryInterface $repository
     * @param Template\TemplateRendererInterface $template
     * @param RouterInterface $router
     * @param CustomerForm $form
     */
    public function __construct(
        CustomerRepositoryInterface $repository,
        Template\TemplateRendererInterface $template,
        RouterInterface $router,
        CustomerForm $form
    )
    {
        $this->template = $template;
        $this->repository = $repository;
        $this->router = $router;
        $this->form = $form;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $customer = $this->repository->find($request->getAttribute('id'));

        $this->form->bind($customer);
        $this->form->add(new HttpMethodElement('DELETE'));

        if ( $request->getMethod() == 'DELETE' ) {

            $this->repository->remove($customer);

            $flash = $request->getAttribute('flash');
            $flash->setMessage(FlashMessageInterface::SUCCESS, 'Contato excluido com sucesso.');
            $uri = $this->router->generateUri('customer.list');
            return new RedirectResponse($uri);
        }

        return new HtmlResponse($this->template->render('app::customer/delete', [
            'form' => $this->form
        ]));
    }
}

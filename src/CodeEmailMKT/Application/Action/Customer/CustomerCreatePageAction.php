<?php

namespace CodeEmailMKT\Application\Action\Customer;

use CodeEmailMKT\Application\Form\CustomerForm;
use CodeEmailMKT\Domain\Entity\Customer;
use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;

class CustomerCreatePageAction
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
        if ( $request->getMethod() == 'POST' ) {

            $dataRow = $request->getParsedBody();
            $this->form->setData($dataRow);

            if ( $this->form->isValid()) {

                $this->repository->create($this->form->getData());
                $flash = $request->getAttribute('flash');
                $flash->setMessage(FlashMessageInterface::SUCCESS, 'Contato criado com sucesso.');
                $uri = $this->router->generateUri('customer.list');
                return new RedirectResponse($uri);

            }


        }
        return new HtmlResponse($this->template->render('app::customer/create',['form'=>$this->form]));
    }
}

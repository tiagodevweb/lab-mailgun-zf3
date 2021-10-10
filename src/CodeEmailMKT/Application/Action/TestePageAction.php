<?php

namespace CodeEmailMKT\Application\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Doctrine\ORM\EntityManager;
use CodeEmailMKT\Domain\Entity\Category;
use CodeEmailMKT\Domain\Entity\Cliente;
use CodeEmailMKT\Domain\Entity\Endereco;
use CodeEmailMKT\Domain\Persistence\CustomerRepositoryInterface;
use CodeEmailMKT\Domain\Entity\Customer;

class TestePageAction
{
	private $template;

	/**
	 * 
	 * @var CustomerRepositoryInterface
	 */
	private $repository;

    public function __construct(CustomerRepositoryInterface $repository, Template\TemplateRendererInterface $template = null)
    {
        $this->template = $template;
        $this->repository = $repository;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {  
    	//$category = new Category;
    	//$category->setName('Nome da minha categoria');

    	//$this->manager->persist($category);
    	//$this->manager->flush();

//        $endereco = new Endereco;
//        $endereco->setCep('12345-123')
//                 ->setLogradouro('Rua 03')
//                 ->setCidade('Cidade 03')
//                 ->setEstado('RS');
//
//        $this->manager->persist($endereco);
//        $this->manager->flush();
//
//        $cliente = new Cliente;
//        $cliente->setNome('Cliente 03')
//                ->setEmail('cliente01@dominio.com')
//                ->setCpf('12345678912')
//                ->setEndereco($endereco);
//
//        $this->manager->persist($cliente);
//        $this->manager->flush();

        $entity = new Customer();
        $entity->setName('Tiago Lopes')
            ->setEmail('tiago@tiago.com');
        $this->repository->create($entity);

        $customers = $this->repository->findAll();

        //$categories = $this->manager->getRepository(Category::class)->findAll();
    	//$clientes = $this->manager->getRepository(Cliente::class)->findAll();
        return new HtmlResponse($this->template->render('app::teste', [
        	'data' => 'Minha primeira aplicação',
            'categories' => [],
            'clientes' => [],
            'customers' => $customers
        ]));
    }
}

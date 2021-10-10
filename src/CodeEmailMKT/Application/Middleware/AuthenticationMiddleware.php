<?php

namespace CodeEmailMKT\Application\Middleware;

use CodeEmailMKT\Domain\Service\AuthInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

class AuthenticationMiddleware
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var AuthInterface
     */
    private $auth;

    public function __construct(RouterInterface $router, AuthInterface $auth)
    {
        $this->router = $router;
        $this->auth = $auth;
    }
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if ( ! $this->auth->isAuth() ) {
            return new RedirectResponse(
                $this->router->generateUri('auth.login')
            );
        }
        return $next($request, $response);
    }

}

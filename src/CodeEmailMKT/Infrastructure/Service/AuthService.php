<?php

namespace CodeEmailMKT\Infrastructure\Service;


use CodeEmailMKT\Domain\Entity\User;
use CodeEmailMKT\Domain\Service\AuthInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\AuthenticationService;

class AuthService implements AuthInterface
{
    /**
     * @var AuthenticationService
     */
    private $authentication;

    /**
     * AuthService constructor.
     * @param AuthenticationService $authentication
     */
    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password): bool
    {
        /**@var ValidatableAdapterInterface $adapter */
        $adapter = $this->authentication->getAdapter();
        $adapter->setIdentity($email)
                ->setCredential($password);
        $result = $this->authentication->authenticate($adapter);
        return $result->isValid();
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->getUser() != null;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->authentication->getIdentity();
    }


    /**
     * @return void
     */
    public function destroy()
    {
        $this->authentication->clearIdentity();
    }
}
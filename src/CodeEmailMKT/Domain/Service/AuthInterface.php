<?php

namespace CodeEmailMKT\Domain\Service;


use CodeEmailMKT\Domain\Entity\User;

interface AuthInterface
{
    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password): bool ;

    /**
     * @return bool
     */
    public function isAuth(): bool;

    /**
     * @return User|null
     */
    public function getUser();

    /**
     * @return void
     */
    public function destroy();
}
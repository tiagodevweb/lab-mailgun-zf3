<?php

namespace CodeEmailMKT\Domain\Service;


interface FlashMessageInterface
{
    const SUCCESS = 0;
    const ERROR = 1;

    /**
     * @param string $namespace
     * @return mixed
     */
    public function setNamespace(string $namespace) :FlashMessageInterface;

    /**
     * @param mixed $key
     * @param string $value
     * @return mixed
     */
    public function setMessage($key, string $value) : FlashMessageInterface;

    /**
     * @param string $key
     * @return mixed
     */
    public function getMessage(string $key);
}
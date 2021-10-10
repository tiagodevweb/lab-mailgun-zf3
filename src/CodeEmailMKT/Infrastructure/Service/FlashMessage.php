<?php

declare(strict_types=1);

namespace CodeEmailMKT\Infrastructure\Service;


use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class FlashMessage implements FlashMessageInterface
{
    /**
     * @var FlashMessenger
     */
    private $flashMessenger;

    /**
     * FlashMessage constructor.
     * @param FlashMessenger $flashMessenger
     */
    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param string $namespace
     * @return mixed
     */
    public function setNamespace(string $namespace = __NAMESPACE__) :FlashMessageInterface
    {
        $this->flashMessenger->setNamespace($namespace);
        return $this;
    }

    /**
     * @param mixed $key
     * @param string $value
     * @return mixed
     */
    public function setMessage($key, string $value) :FlashMessageInterface
    {
        switch ( $key ) {
            case self::SUCCESS :
                $this->flashMessenger->addSuccessMessage($value);
                break;
            case self::ERROR :
                $this->flashMessenger->addErrorMessage($value);
                break;
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getMessage(string $key)
    {
        $result = [];
        switch ( $key ) {
            case self::SUCCESS :
                $result = $this->flashMessenger->getCurrentSuccessMessages();
                break;
            case self::ERROR :
                $result = $this->flashMessenger->getCurrentErrorMessages();
                break;
        }
        return count($result) ? $result[0] : null;
    }
}
<?php

namespace CodeEmailMKT\Infrastructure\Service;

use Interop\Container\ContainerInterface;
use Mailgun\Mailgun;

class MailgunFactory
{
    public function __invoke(ContainerInterface $container): Mailgun
    {
        return new Mailgun($container->get('config')['mailgun']['key']);
    }
}
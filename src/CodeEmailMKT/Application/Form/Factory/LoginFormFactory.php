<?php

namespace CodeEmailMKT\Application\Form\Factory;


use CodeEmailMKT\Application\Form\LoginForm;
use CodeEmailMKT\Application\InputFilter\LoginInputFilter;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class LoginFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $form = new LoginForm();
        //$form->setHydrator(new ClassMethods());
        //$form->setObject(new Customer());
        $form->setInputFilter(new LoginInputFilter());
        return $form;
    }
}
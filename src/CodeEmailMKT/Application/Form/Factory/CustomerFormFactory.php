<?php

namespace CodeEmailMKT\Application\Form\Factory;


use CodeEmailMKT\Application\Form\CustomerForm;
use CodeEmailMKT\Application\InputFilter\CustomerInputFilter;
use CodeEmailMKT\Domain\Entity\Customer;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class CustomerFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $entityManager = $container->get(EntityManager::class);
        $form = new CustomerForm();
        $form->setHydrator(new DoctrineHydrator($entityManager));
        $form->setObject(new Customer());
        $form->setInputFilter(new CustomerInputFilter());
        $form->setObjectManager($entityManager);
        $form->init();
        return $form;
    }
}
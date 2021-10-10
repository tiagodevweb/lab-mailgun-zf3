<?php

namespace CodeEmailMKT\Application\Form\Factory;


use CodeEmailMKT\Application\Form\TagForm;
use CodeEmailMKT\Application\InputFilter\TagInputFilter;
use CodeEmailMKT\Domain\Entity\Tag;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class TagFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $form = new TagForm();
        $form->setHydrator(new ClassMethods());
        $form->setObject(new Tag());
        $form->setInputFilter(new TagInputFilter());
        return $form;
    }
}
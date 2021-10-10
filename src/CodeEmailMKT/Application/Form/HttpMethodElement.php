<?php

namespace CodeEmailMKT\Application\Form;


use Zend\Form\Element\Hidden;

class HttpMethodElement extends Hidden
{
    public function __construct($value, array $options = [])
    {
        parent::__construct('_method', $options);
        $this->setValue($value);
    }

}
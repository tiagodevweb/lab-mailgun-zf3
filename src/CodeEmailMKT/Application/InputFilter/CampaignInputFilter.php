<?php

namespace CodeEmailMKT\Application\InputFilter;


use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

class CampaignInputFilter extends InputFilter
{

    /**
     * CampaignInputFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Este campo é requerido'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'subject',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'break_chain_on_failure' => true,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Este campo é requerido'
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'tags',
            'required' => false
        ]);

        $this->add([
            'name' => 'template',
            'required' => true,
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Este campo é requerido'
                        ]
                    ]
                ]
            ]
        ]);
    }
}
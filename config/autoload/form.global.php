<?php

use CodeEmailMKT\Application\Form\{CustomerForm,LoginForm,TagForm,CampaignForm};
use CodeEmailMKT\Application\Form\Factory\{CustomerFormFactory,LoginFormFactory,TagFormFactory,CampaignFormFactory};
use CodeEmailMKT\Infrastructure\View\HelperPluginManagerFactory;
use Zend\View\HelperPluginManager;

$forms = [
    'dependencies' => [
        'aliases' => [

        ],
        'invokables' => [

        ],
        'factories' => [
            HelperPluginManager::class => HelperPluginManagerFactory::class,
            CustomerForm::class => CustomerFormFactory::class,
            LoginForm::class => LoginFormFactory::class,
            TagForm::class => TagFormFactory::class,
            CampaignForm::class => CampaignFormFactory::class
        ]
    ],

    'view_helpers' => [
        'aliases' => [

        ],
        'invokables' => [

        ],
        'factories' => [
            'identity' => View\Helper\Service\IdentityFactory::class
        ]
    ]
];

$configProviderForm = (new \Zend\Form\ConfigProvider())->__invoke();
return \Zend\Stdlib\ArrayUtils::merge($configProviderForm, $forms);
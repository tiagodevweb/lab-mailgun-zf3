<?php

use CodeEmailMKT\Application\Action\{
    HomePageAction,TestePageAction,LoginPageAction,LogoutAction,
    HomePageFactory,TestePageFactory,LoginPageFactory,LogoutFactory
};

use CodeEmailMKT\Application\Action\Customer\{
    CustomerListPageAction,CustomerCreatePageAction,CustomerUpdatePageAction,CustomerDeletePageAction
};
use CodeEmailMKT\Application\Action\Customer\Factory\{
    CustomerListPageFactory,CustomerCreatePageFactory,CustomerUpdatePageFactory,CustomerDeletePageFactory
};

use CodeEmailMKT\Application\Action\Tag\{
    TagListPageAction,TagCreatePageAction,TagUpdatePageAction,TagDeletePageAction
};
use CodeEmailMKT\Application\Action\Tag\Factory\{
    TagListPageFactory,TagCreatePageFactory,TagUpdatePageFactory,TagDeletePageFactory
};

use CodeEmailMKT\Application\Action\Campaign\{
    CampaignListPageAction, CampaignCreatePageAction, CampaignReportPageAction, CampaignSenderPageAction, CampaignUpdatePageAction, CampaignDeletePageAction
};
use CodeEmailMKT\Application\Action\Campaign\Factory\{
    CampaignListPageFactory, CampaignCreatePageFactory, CampaignReportPageFactory, CampaignSenderPageFactory, CampaignUpdatePageFactory, CampaignDeletePageFactory
};
use CodeEmailMKT\Domain\Service\CampaignReportInterface;
use CodeEmailMKT\Infrastructure\Service\CampaignReportFactory;

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            CodeEmailMKT\Application\Action\PingAction::class => CodeEmailMKT\Application\Action\PingAction::class,
        ],
        'factories' => [
            HomePageAction::class => HomePageFactory::class,
            TestePageAction::class => TestePageFactory::class,
            LoginPageAction::class => LoginPageFactory::class,
            LogoutAction::class => LogoutFactory::class,
            CustomerListPageAction::class => CustomerListPageFactory::class,
            CustomerCreatePageAction::class => CustomerCreatePageFactory::class,
            CustomerUpdatePageAction::class => CustomerUpdatePageFactory::class,
            CustomerDeletePageAction::class => CustomerDeletePageFactory::class,
            TagListPageAction::class => TagListPageFactory::class,
            TagCreatePageAction::class => TagCreatePageFactory::class,
            TagUpdatePageAction::class => TagUpdatePageFactory::class,
            TagDeletePageAction::class => TagDeletePageFactory::class,
            CampaignListPageAction::class => CampaignListPageFactory::class,
            CampaignCreatePageAction::class => CampaignCreatePageFactory::class,
            CampaignUpdatePageAction::class => CampaignUpdatePageFactory::class,
            CampaignDeletePageAction::class => CampaignDeletePageFactory::class,
            CampaignSenderPageAction::class => CampaignSenderPageFactory::class,
            CampaignReportPageAction::class => CampaignReportPageFactory::class,
            CampaignReportInterface::class => CampaignReportFactory::class
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => CodeEmailMKT\Application\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'api.ping',
            'path' => '/api/ping',
            'middleware' => CodeEmailMKT\Application\Action\PingAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'teste',
            'path' => '/teste',
            'middleware' => CodeEmailMKT\Application\Action\TestePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'auth.login',
            'path' => '/auth/login',
            'middleware' => CodeEmailMKT\Application\Action\LoginPageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'auth.logout',
            'path' => '/auth/logout',
            'middleware' => CodeEmailMKT\Application\Action\LogoutAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.list',
            'path' => '/admin/customers',
            'middleware' => CustomerListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'customer.create',
            'path' => '/admin/customer/create',
            'middleware' => CustomerCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'customer.update',
            'path' => '/admin/customer/update/{id}',
            'middleware' => CustomerUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'customer.delete',
            'path' => '/admin/customer/{id}/delete',
            'middleware' => CustomerDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'tag.list',
            'path' => '/admin/tags',
            'middleware' => TagListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'tag.create',
            'path' => '/admin/tag/create',
            'middleware' => TagCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'tag.update',
            'path' => '/admin/tag/update/{id}',
            'middleware' => TagUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'tag.delete',
            'path' => '/admin/tag/{id}/delete',
            'middleware' => TagDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.list',
            'path' => '/admin/campaigns',
            'middleware' => CampaignListPageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'campaign.create',
            'path' => '/admin/campaign/create',
            'middleware' => CampaignCreatePageAction::class,
            'allowed_methods' => ['GET','POST'],
        ],
        [
            'name' => 'campaign.update',
            'path' => '/admin/campaign/update/{id}',
            'middleware' => CampaignUpdatePageAction::class,
            'allowed_methods' => ['GET','PUT'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.delete',
            'path' => '/admin/campaign/{id}/delete',
            'middleware' => CampaignDeletePageAction::class,
            'allowed_methods' => ['GET','DELETE'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.sender',
            'path' => '/admin/campaign/{id}/sender',
            'middleware' => CampaignSenderPageAction::class,
            'allowed_methods' => ['GET','POST'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ],
        [
            'name' => 'campaign.report',
            'path' => '/admin/campaign/{id}/report',
            'middleware' => CampaignReportPageAction::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'tokens' => [
                    'id' => '\d+'
                ]
            ]
        ]
    ],
];

<?php

return [
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => [
					'host' => 'localhost',
					'port' => '3306',
					'user' => 'homestead',
					'password' => 'secret',
					'dbname' => 'codeemailmkt',
					'driverOptions' => [
						\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
					]
				]
			]
		],
		'driver' => [
			'CodeEmailMKT_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . '/../../src/CodeEmailMKT/Infrastructure/Persistence/Doctrine/ORM']
			],
			'orm_default' => [
				'drivers' => [
					'CodeEmailMKT\Domain\Entity' => 'CodeEmailMKT_driver'
				]
			]
		],
        'authentication' => [
            'orm_default' => [
                'object_manager' => \Doctrine\ORM\EntityManager::class,
                'identity_class' => \CodeEmailMKT\Domain\Entity\User::class,
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function(\CodeEmailMKT\Domain\Entity\User $user, $passwordGiven){
                    return password_verify($passwordGiven, $user->getPassword());
                }
            ],
        ]
	]
];
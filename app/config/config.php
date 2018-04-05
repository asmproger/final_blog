<?php

$this->import('parameters.yml');
$this->import('security.yml');
$this->import('services.yml');


$container->setParameter('locale', 'en');
$container->setParameter('images_directory', '%kernel.project_dir%/web/uploaded_images');

$container->loadFromExtension('framework', [
    'translator' => [
        'fallbacks' => ['%locale%']
    ],
    'secret' => '%secret%',
    'router' => [
        'resource' => '%kernel.project_dir%/app/config/routing.yml',
        'strict_requirements' => '~'
    ],
    'form' => [],
    'csrf_protection' => null,
    'validation' => [
        'enable_annotations' => true
    ],
    'default_locale' => '%locale%',
    'trusted_hosts' => [],
    'session' => [
        'handler_id' => 'session.handler.native_file',
        'save_path' => '%kernel.project_dir%/var/sessions/%kernel.environment%'
    ],
    'fragments' => [],
    'http_method_override' => true,
    'assets' => [],
    'php_errors' => ['log' => true],
    'templating' => ['engines' => ['twig']]
]);

$container->loadFromExtension('twig', [
    'debug' => '%kernel.debug%',
    'strict_variables' => '%kernel.debug%',
    'form_themes' => ['bootstrap_3_layout.html.twig']
]);

$container->loadFromExtension('doctrine', [
    'dbal' => [
        'types' => ['json' => 'Sonata\Doctrine\Types\JsonType'],
        'driver' => 'pdo_mysql',
        'host' => '%database_host%',
        'port' => '%database_port%',
        'dbname' => '%database_name%',
        'user' => '%database_user%',
        'password' => '%database_password%',
        'charset' => 'UTF8',
    ],
    'orm' => [
        'auto_generate_proxy_classes' => '%kernel.debug%',
        'entity_managers' => [
            'default' => [
                'mappings' => [
                    'AppBundle' => [],
                    'ApplicationSonataUserBundle' => [],
                    'SonataUserBundle' => [],
                    'FOSUserBundle' => []
                ]
            ]
        ]
    ]
]);

$container->loadFromExtension('swiftmailer', [
    'transport' => '%mailer_transport%',
    'host' => '%mailer_host%',
    'username' => '%mailer_user%',
    'password' => '%mailer_password%',
    'spool' => ['type' => 'memory']
]);

$container->loadFromExtension('fos_user', [
    'db_driver' => 'orm',
    'firewall_name' => 'main',
    'user_class' => 'Application\Sonata\UserBundle\Entity\User',
    'from_email' => [
        'address' => 'no-reply@test_blog.local',
        'sender_name' => 'test_blog robot'
    ],
    'group' => [
        'group_class' => 'Application\Sonata\UserBundle\Entity\Group',
        'group_manager' => 'sonata.user.orm.group_manager'
    ],
    'registration' => [
        'form' => [
            'name' => 'custom_registration_form',
            'type' => 'AppBundle\Form\RegistrationType'
        ]
    ],
    'service' => [
        'user_manager' => 'sonata.user.orm.user_manager'
    ]
]);

$container->loadFromExtension('sonata_block', [
    'blocks' => [
        'sonata.admin.block.admin_list' => [
            'contexts' => ['admin']
        ]
    ]
]);

$container->loadFromExtension('sonata_user', [
    'class' => [
        'user' => 'Application\Sonata\UserBundle\Entity\User',
        'group' => 'Application\Sonata\UserBundle\Entity\Group'
    ],
    'security_acl' => true,
    'manager_type' => 'orm'
]);

$container->loadFromExtension('sonata_block', [
    'blocks' => [
        'sonata.user.block.menu' => [],    # used to display the menu in profile pages
        'sonata.user.block.account' => [], # used to display menu option (login option)
        'sonata.block.service.text' => [] # used to if you plan to use Sonata user routes
    ]
]);

$container->loadFromExtension('ivory_ck_editor', [
    'input_sync' => true,
    'default_config' => 'base_config',
    'configs' => [
        'base_config' => [
            'toolbar' => [
                'name' => 'styles',
                'items' => ['Bold', 'Italic', 'BulletedList', 'Link']
            ]
        ]
    ]
]);

$container->loadFromExtension('hwi_oauth', [
    'firewall_names' => ['main'],
    'resource_owners' => [
        'google' => [
            'type' => 'google',
            'client_id' => '%google_client_id%',
            'client_secret' => '%google_client_secret%',
            'scope' => "email profile",
            'options' => [
                'csrf' => true
            ]
        ],
        'facebook' => [
            'type' => 'facebook',
            'client_id' => '%fb_client_id%',
            'client_secret' => '%fb_client_secret%',
            'scope' => 'email',
            'options' => [
                'display' => 'popup',
                'auth_type' => 'rerequest'
            ]
        ]
    ]
]);
<?php

$this->import('config.php');

$container->loadFromExtension('framework', [
    'router' => [
        'resource' => '%kernel.project_dir%/app/config/routing_dev.yml',
        'strict_requirements' => true
    ],
    'profiler' => ['only_exceptions' => false]
]);

$container->loadFromExtension('web_profiler', [
    'toolbar' => true,
    'intercept_redirects' => false
]);

$container->loadFromExtension('monolog', [
    'handlers' => [
        'main' => [
            'type' => 'stream',
            'path' => '%kernel.logs_dir%/%kernel.environment%.log',
            'level' => 'debug',
            'channels' => ['!event']
        ],
        'console' => [
            'type' => 'console',
            'process_psr_3_messages' => false,
            'channels' => ['!event', '!doctrine', '!console']
        ],
        'server_log' => [
            'type' => 'server_log',
            'process_psr_3_messages' => false,
            'host' => '127.0.0.1:9911'
        ]
    ]
]);
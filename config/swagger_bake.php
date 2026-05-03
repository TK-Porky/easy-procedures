<?php
return [
    'SwaggerBake' => [
        'prefix' => '/api/v1',
        'yml' => '/config/swagger.yml',
        'json' => '/webroot/swagger.json',
        'webPath' => '/swagger.json',
        'hotReload' => true,
        'exceptionSchema' => 'Exception',
        'requestAccepts' => ['application/json'],
        'responseContentType' => 'application/json',
        'namespaces' => [
            'controllers' => ['App\\Controller\\Api\\V1'],
            'entities' => ['App\\Model\\Entity'],
            'tables' => ['App\\Model\\Table'],
        ],
        'components' => [
            'SecuritySchemes' => [
                'BearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                ],
            ],
        ],
    ]
];

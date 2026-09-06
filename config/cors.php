<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | such as specifying which origins are allowed to make requests to your
    | application. By default, only same-origin requests are allowed.
    |
    | Supported: "origin", "methods", "allowedOrigins", "allowedOriginsPatterns",
    | "allowedHeaders", "exposedHeaders", "maxAge", "supportsCredentials"
    |
    */

    'paths' => ['api/*'],

    'allowedMethods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowedOrigins' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('CORS_ALLOWED_ORIGINS', '')),
    ))),

    'allowedOriginsPatterns' => [],

    'allowedHeaders' => ['Accept', 'Authorization', 'Content-Type', 'X-Requested-With', 'X-CSRF-TOKEN'],

    'exposedHeaders' => [],

    'maxAge' => 0,

    'supportsCredentials' => true,

];

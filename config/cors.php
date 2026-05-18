<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Sadece Angular projenin (4200 portu) erişmesine izin veriyoruz
    'allowed_origins' => ['http://localhost:4200'], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // İleride login işlemleri (cookie/session) yapabilmen için true yaptık
    'supports_credentials' => true, 

];
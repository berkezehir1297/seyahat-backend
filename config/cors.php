<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Hem canlıdaki Render sitene hem de lokal Angular'a izin verdik
    'allowed_origins' => [
        'http://localhost:4200',
        'https://seyahat-frontend.onrender.com'
    ], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Login işlemleri (cookie/session/token) için true kalmalı
    'supports_credentials' => true, 

];
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Dünyadaki tüm adreslerden gelen isteklere izin veriyoruz (CORS hatasını kökten çözer)
    'allowed_origins' => ['*'], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // allowed_origins '*' (her yer) olduğunda supports_credentials güvenlik nedeniyle false olmalıdır
    'supports_credentials' => false, 

];
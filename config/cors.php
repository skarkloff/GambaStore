<?php

return [
    'paths'                    => ['api/*', 'api/api/*'], 
    
    'allowed_methods'          => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'allowed_origins'          => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000,http://localhost:5173')),
    'allowed_origins_patterns' => [],
    
    'allowed_headers'          => ['*'], 
    
    'exposed_headers'          => [],
    'max_age'                  => 86400,
    
    'supports_credentials'     => true, 
];
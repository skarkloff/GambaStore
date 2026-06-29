<?php

return [
    'paths'                    => ['api/*', 'api/api/*'], 
    
    'allowed_methods'          => ['POST', 'GET', 'OPTIONS', 'PATCH', 'DELETE'],
    'allowed_origins'          => ['https://gambastore-frontend.vercel.app'],
    'allowed_origins_patterns' => [],
    
    'allowed_headers'          => ['*'], 
    
    'exposed_headers'          => [],
    'max_age'                  => 86400,
    
    'supports_credentials'     => true, 
];
<?php

return [
    'model'           => App\Models\Tenant::class,
    'identifier'      => 'subdomain',
    'default_database'=> env('DB_DATABASE', 'laravel'),
];


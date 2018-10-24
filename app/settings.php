<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db'                  => [
            'driver'    => env('DATABASE_DRIVER', 'mysql'),
            'host'      => env('DATABASE_HOST', 'localhost'),
            'database'  => env('DATABASE_NAME', 'board'),
            'username'  => env('DATABASE_USER', 'root'),
            'password'  => env('DATABASE_SECRET', ''),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => env('DB_COLLATION', 'utf8'),
            'prefix'    => env('DB_PREFIX', 'board_'),
        ],
    ],
];

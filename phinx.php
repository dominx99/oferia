<?php

require_once './vendor/autoload.php';

$loader = new \Dotenv\Dotenv(__DIR__);
$loader->load();

$settings = require './app/settings.php';

$app       = new \Slim\App($settings);
$container = $app->getContainer();
$container->register(new \App\Services\Providers\EloquentServiceProvider($container));

return [
    'paths'                => [
        'migrations' => './db/migrations',
        'seeds'      => './db/seeds',
    ],
    'migration_base_class' => 'Migration',
    'templates'            => [
        'file' => './app/Migration/Template.php.dist',
    ],
    'environments'         => [
        'default_migration_table' => 'migrations',
        'default_database'        => env('APP_ENV'),
        env('APP_ENV')            => [
            'adapter'      => env('DB_DRIVER'),
            'host'         => env('DB_HOST'),
            'name'         => env('DB_NAME'),
            'user'         => env('DB_USER'),
            'pass'         => env('DB_SECRET'),
            'port'         => env('DB_PORT'),
            'charset'      => env('DB_CHARSET'),
            'collation'    => env('DB_COLLATION'),
            'table_prefix' => env('DB_PREFIX'),
        ],
    ],
    'version_order'        => 'creation',
];

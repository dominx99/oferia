<?php

$container = $app->getContainer();
$container->register(new \App\Services\Providers\EloquentServiceProvider($container));

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views', [
        'cache' => false,
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

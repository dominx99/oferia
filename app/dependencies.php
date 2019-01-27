<?php

$container = $app->getContainer();
$container->register(new \App\Services\Providers\EloquentServiceProvider($container));

$container[\App\Auth\Auth::class] = function () {
    return new \App\Auth\Auth();
};

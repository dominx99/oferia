<?php

$container = $app->getContainer();
$container->register(new \App\Services\Providers\EloquentServiceProvider());

$container[\App\Auth\Auth::class] = function () {
    return new \App\Auth\Auth();
};

$container[\App\Auth\Token::class] = function () {
    return new \App\Auth\Token();
};

$container[\Rakit\Validation\Validator::class] = function () {
    return new \Rakit\Validation\Validator();
};

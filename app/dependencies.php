<?php

$container = $app->getContainer();
$container->register(new \App\Services\Providers\EloquentServiceProvider($container));

<?php

use App\Actions\Auth\AuthLoginAction;

$app->group('/api', function () use ($app) {
    $app->post('/auth/login', AuthLoginAction::class);
});

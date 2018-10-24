<?php

session_start();

require_once './vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$settings = require './app/settings.php';

$app = new \Slim\App($settings);

require './app/dependencies.php';
require './app/routes.php';

$app->run();

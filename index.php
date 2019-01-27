<?php

session_start();

require_once './vendor/autoload.php';

$app = new \App\App();

$app->run();

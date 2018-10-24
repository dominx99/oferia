<?php

require_once './vendor/autoload.php';

use Slim\App;

$settings = require './app/settings.php';

$app = new App($settings);

require './app/dependencies.php';
require './app/routes.php';

$app->run();

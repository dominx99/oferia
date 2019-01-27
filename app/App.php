<?php

namespace App;

use Slim\App as SlimApp;

class App extends SlimApp
{
    /**
     * Constructor of App
     * It loads all dependencies, routes etc.
     */
    public function __construct()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/..//');
        $dotenv->load();

        $app = $this;

        $settings = require __DIR__ . '/settings.php';

        parent::__construct($settings);

        require __DIR__ . '/dependencies.php';
        require __DIR__ . '/routes/api.php';

        return $app;
    }
}

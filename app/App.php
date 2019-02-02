<?php

namespace App;

use Slim\App as SlimApp;

class App extends SlimApp
{
    /**
     * Constructor of App
     * It loads all dependencies, routes etc.
     * @param string $envFilename
     */
    public function __construct(string $envFilename = '.env')
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/..//', $envFilename);
        $dotenv->load();

        $app = $this;

        $settings = require __DIR__ . '/settings.php';

        parent::__construct($settings);

        require_once __DIR__ . '/helpers.php';
        require __DIR__ . '/dependencies.php';
        require __DIR__ . '/routes/api.php';
    }
}

<?php

namespace App;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->app       = $this->createApplication();
        $this->container = $this->app->getContainer();
    }

    public function createApplication()
    {
        return new App();
    }
}

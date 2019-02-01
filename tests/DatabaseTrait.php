<?php

namespace App;

use Phinx\Config\Config;
use Phinx\Console\PhinxApplication;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

trait DatabaseTrait
{
    /**
     * Migrates all tables
     */
    public function migrate()
    {
        $path        = __DIR__ . '/../phinx.php';
        $configArray = require $path;
        $config      = new Config($configArray);

        $manager = new Manager($config, new StringInput(' '), new NullOutput());
        $manager->migrate('testing');
    }

    /**
     * Rollback all migrations
     */
    protected function rollback()
    {
        $app = new PhinxApplication();
        $app->doRun(new StringInput("rollback -e testing -f"), new NullOutput());
    }
}

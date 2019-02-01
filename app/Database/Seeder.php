<?php

namespace App\Database;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factory;
use Phinx\Seed\AbstractSeed;

abstract class Seeder extends AbstractSeed
{
    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;

    /**
     * Loads all factories from db/factories
     *
     * @return void
     */
    public function boot(): void
    {
        $faker   = Faker::create();
        $factory = new Factory($faker);

        $factories = __DIR__ . '/../../db/factories';
        $dir       = opendir($factories);

        while ($entry = readdir($dir)) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            require $factories . '/' . $entry;
        }

        $this->factory = $factory;
    }
}

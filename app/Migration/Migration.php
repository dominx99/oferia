<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /**
     * @var \Illuminate\Database\Capsule\Manager $capsule
     */

    protected $capsule;

    /**
     * @var \Illuminate\Database\Schema\Builder $schema
     */
    protected $schema;

    /**
     * @return void
     */
    public function init(): void
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver'    => env('DATABASE_DRIVER', 'mysql'),
            'host'      => env('DATABASE_HOST', 'localhost'),
            'database'  => env('DATABASE_NAME', 'board'),
            'username'  => env('DATABASE_USER', 'root'),
            'password'  => env('DATABASE_PASS', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'board_',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->capsule = $capsule;
        $this->schema  = $this->capsule->schema();
    }
}

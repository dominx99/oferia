<?php

namespace App\Database;

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
        $this->capsule = new Manager();
        $this->schema  = $this->capsule->schema();
    }
}

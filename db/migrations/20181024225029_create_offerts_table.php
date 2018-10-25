<?php

use App\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffertsTable extends Migration
{
    public function up()
    {
        $this->schema->create("offerts", function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop("offerts");
    }
}

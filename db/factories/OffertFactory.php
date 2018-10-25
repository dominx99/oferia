<?php

use App\Models\Offert;
use Faker\Generator as Faker;

$factory->define(Offert::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Providers;
use Faker\Generator as Faker;

$factory->define(Providers::class, function (Faker $faker) {
    return [
        "name" => $faker->word
    ];
});

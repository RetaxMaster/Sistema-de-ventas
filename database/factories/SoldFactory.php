<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sold;
use Faker\Generator as Faker;

$factory->define(Sold::class, function (Faker $faker) {
    return [
        "product" => rand(1, 10),
        "quantity" => rand(1, 6),
        "payed" => $faker->randomFloat(2, 10, 500),
        "sale" => rand(1, 3)
    ];
});

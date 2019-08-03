<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sold;
use Faker\Generator as Faker;

$factory->define(Sold::class, function (Faker $faker) {
    return [
        "user" => 2,
        "product" => rand(1, 10),
        "quantity" => rand(1, 6)
    ];
});

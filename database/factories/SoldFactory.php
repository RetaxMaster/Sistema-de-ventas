<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sold;
use Faker\Generator as Faker;

$factory->define(Sold::class, function (Faker $faker) {
    return [
        "user" => 2,
        "product" => rand(1, 10),
        "quantity" => rand(1, 6),
        "disccount" => rand(0, 100),
        "payed" => $faker->randomFloat(2, 10, 500),
        "payment_method" => rand(1, 2)
    ];
});

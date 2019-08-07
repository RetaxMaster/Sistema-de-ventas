<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sales;
use Faker\Generator as Faker;

$factory->define(Sales::class, function (Faker $faker) {
    return [
        "user" => rand(1, 2),
        "disccount" => rand(0, 50),
        "payment_method" => rand(1, 2),
        "subtotal" => $faker->randomFloat(2, 50, 250),
        "total" => $faker->randomFloat(2, 50, 250),
        "comment" => $faker->paragraph,
        "ticket_url" => $faker->word()
    ];
});

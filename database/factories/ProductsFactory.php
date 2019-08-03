<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence(5),
        "brand" => $faker->word,
        "category" => rand(1, 4),
        "public_price" => $faker->randomFloat(2, 10, 500),
        "major_price" => $faker->randomFloat(2, 10, 500),
        "provider_price" => $faker->randomFloat(2, 10, 500),
        "code" => $faker->numerify("#### #### #### ####"),
        "provider" => rand(1, 3),
        "sell_type" => rand(1, 3),
        "description" => $faker->paragraph,
        "stock" => rand(2, 50),
        "image" => "https://lh3.googleusercontent.com/bFbUtXL3sEjlxfrWhTaDEN-CuBONeM5x2YpJ2DCQ64rY-vrEOckeW6v7mJ-XLXFLw7wZDV8=s85"
    ];
});

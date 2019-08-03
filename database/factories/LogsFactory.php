<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Logs;
use Faker\Generator as Faker;

$factory->define(Logs::class, function (Faker $faker) {
    return [
        "action" => $faker->paragraph,
        "user" => rand(1, 2)
    ];
});

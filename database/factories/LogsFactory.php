<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Logs;
use Faker\Generator as Faker;

$factory->define(Logs::class, function (Faker $faker) {
    return [
        "action" => rand(1, 9),
        "user" => rand(1, 2)
    ];
});

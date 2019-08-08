<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Data;
use Faker\Generator as Faker;

$factory->define(Data::class, function (Faker $faker) {
    return [
        "cash_register" => 0,
        "is_open" => false
    ];
});

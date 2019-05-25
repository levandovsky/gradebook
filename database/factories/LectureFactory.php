<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Lecture;
use Faker\Generator as Faker;

$factory->define(Lecture::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->realText(600)
    ];
});

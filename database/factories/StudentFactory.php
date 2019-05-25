<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'lastname' => $faker->lastName,
        'phone' => $faker->unique()->numerify('3706#######'),
        'email' => $faker->unique()->safeEmail
    ];
});

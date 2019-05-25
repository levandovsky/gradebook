<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Grade;
use App\Student;
use App\Lecture;
use Faker\Generator as Faker;

$factory->define(Grade::class, function (Faker $faker) {
    return [
        'student_id' => function() {
            return factory(Student::class)->create()->id;
        },
        'lecture_id' => function() {
            return factory(Lecture::class)->create()->id;
        },
        'grade' => $faker->numberBetween(1, 10)
    ];
});

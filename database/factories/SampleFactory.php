<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\demo;
use Faker\Generator as Faker;

$factory->define(demo::class, function (Faker $faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'mobile' => $faker->e164PhoneNumber,
        'email' => $faker->unique()->safeEmail,
    ];
});

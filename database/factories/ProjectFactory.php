<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'summary' => $faker->text,
        'status' => false,
        'due_date' => $faker->dateTimeThisMonth()
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
    ];
});

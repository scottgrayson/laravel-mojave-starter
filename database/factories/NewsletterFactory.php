<?php

use Faker\Generator as Faker;

$factory->define(App\Newsletter::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->paragraph,
    ];
});

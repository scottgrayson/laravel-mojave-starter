<?php

use Faker\Generator as Faker;

$factory->define(App\Newsletter::class, function (Faker $faker) {
    return [
        'subject' => $faker->word,
        'body' => $faker->paragraph,
        'sent_at' => $faker->dateTimeThisYear(),
    ];
});

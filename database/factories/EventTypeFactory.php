<?php

use Faker\Generator as Faker;

$factory->define(App\EventType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'emoji' => $faker->emoji,
        'link' => config('app.url'),
    ];
});

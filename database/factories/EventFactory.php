<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'emoji' => $faker->emoji,
        'link' => config('app.url'),
        'date' => $faker->date,
    ];
});

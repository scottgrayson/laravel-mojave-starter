<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'title' => $faker->word,
        'layout' => 'app',
        'uri' => '/'.$faker->word,
        'content' => $faker->paragraph,
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\MenuItem::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'label' => $faker->word,
        'lft' => 0,
    ];
});

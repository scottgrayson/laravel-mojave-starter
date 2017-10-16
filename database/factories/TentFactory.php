<?php

use Faker\Generator as Faker;

$factory->define(App\Tent::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'grade' => rand(1, 6),
        'sex' => array_rand(['m', 'f']),
        'camper_limit' => 30,
    ];
});

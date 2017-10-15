<?php

use Faker\Generator as Faker;

$factory->define(App\Tent::class, function (Faker $faker) {
    return [
        'grade' => rand(1, 6),
        'sex' => array_rand(['m', 'f']),
    ];
});

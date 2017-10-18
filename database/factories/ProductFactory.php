<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->word,
        'price' => 50,
    ];
});

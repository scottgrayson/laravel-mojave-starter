<?php

use Faker\Generator as Faker;

$factory->define(App\NewsletterUrl::class, function (Faker $faker) {
    return [
        'target' => $faker->url,
        'slug' => $faker->uuid,
    ];
});

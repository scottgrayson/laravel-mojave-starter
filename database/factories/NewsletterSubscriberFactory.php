<?php

use Faker\Generator as Faker;

$factory->define(App\NewsletterSubscriber::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
    ];
});

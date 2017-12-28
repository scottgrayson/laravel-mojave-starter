<?php

use Faker\Generator as Faker;

$factory->define(App\NewsletterClick::class, function (Faker $faker) {
    return [
        'ip_address' => $faker->ipv4,
        'user_agent' => $faker->userAgent,
    ];
});

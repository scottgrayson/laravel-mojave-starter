<?php

use Faker\Generator as Faker;

$factory->define(App\Payment::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'transaction' => 'braintree id',
        'amount' => '50.00',
    ];
});

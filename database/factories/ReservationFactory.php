<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Reservation::class, function (Faker $faker) {
    $nextJune = Carbon::now() > Carbon::parse('June')
        ? Carbon::parse('June')->addYears(1)
        : Carbon::parse('June');

    return [
        'date' => $nextJune->addDays(rand(0, 6 * 7))->toDateString(),
    ];
});

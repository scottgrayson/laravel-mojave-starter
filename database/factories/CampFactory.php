<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Camp::class, function (Faker $faker) {
    $nextJune = Carbon::now() > Carbon::parse('June')
        ? Carbon::parse('June')->addYears(1)
        : Carbon::parse('June');

    $nextJune = $nextJune->isWeekend() ? $nextJune->addDays(2) : $nextJune;

    return [
        'camp_start' => $nextJune->toDateString(),
        'camp_end' => $nextJune->addDays(6 * 7)->toDateString(),
        'registration_end' => $nextJune->subMonths(1)->toDateString(),
    ];
});

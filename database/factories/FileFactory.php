<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'name' => $faker->filename,
        'type' => $faker->randomElement(['image', 'text']),
        'bucket' => config('filesystems.disks.s3.bucket'),
        'path' => $faker->word,
    ];
});

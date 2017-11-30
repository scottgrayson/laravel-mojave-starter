<?php

use Illuminate\Database\Seeder;
use App\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camp = \App\Camp::current();

        foreach ($camp->openDays() as $day) {
            factory(\App\Event::class)->create([
                'date' => $day->toDateString(),
            ]);
        }
    }
}

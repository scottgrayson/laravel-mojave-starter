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

        // keyed by dow
        $options = [
            5 => factory(\App\EventType::class)->create(['name' => 'Theater', 'emoji' => '🎭']),
            4 => factory(\App\EventType::class)->create(['name' => 'Cookout', 'emoji' => '🍴']),
            2 => factory(\App\EventType::class)->create(['name' => 'Tye Dye', 'emoji' => '👕']),
        ];

        foreach ($camp->openDays() as $day) {
            $dow = $day->dayOfWeek;
            if (isset($options[$dow])) {
                $type = $options[$dow];
                factory(\App\Event::class)->create([
                    'event_type_id' => $type->id,
                    'date' => $day->toDateString(),
                ]);
            }
        }
    }
}

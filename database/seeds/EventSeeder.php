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
            5 => ['name' => 'Theater', 'emoji' => '🎭'],
            4 => ['name' => 'Cookout', 'emoji' => '🍴'],
            2 => ['name' => 'Tye Dye', 'emoji' => '👕']
        ];

        foreach ($camp->openDays() as $day) {
            $dow = $day->dayOfWeek;
            if (isset($options[$dow])) {
                $type = $options[$dow];
                factory(\App\Event::class)->create([
                    'name' => $type['name'],
                    'emoji' => $type['emoji'],
                    'date' => $day->toDateString(),
                ]);
            }
        }
    }
}

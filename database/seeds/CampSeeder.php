<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $upcomingJune = Carbon::now() > Carbon::parse('June')
            ? Carbon::parse('June 15')->addYears(1)
            : Carbon::parse('June 15');

        $start_dates = [
            $upcomingJune->copy()->subYears(1),
            $upcomingJune->copy(),
            $upcomingJune->copy()->addYears(1),
        ];

        foreach ($start_dates as $start) {
            $start = $start->isWeekend() ? $start->addDays(2) : $start;

            factory(\App\Camp::class)->create([
                'camp_start' => $start->toDateString(),
                'camp_end' => $start->addDays(6 * 7)->toDateString(),
                'registration_end' => $start->subMonths(1)->toDateString(),
            ]);
        }
    }
}
<?php

use Illuminate\Database\Seeder;
use App\Camper;
use App\CampDates;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campers = Camper::limit(Camper::count() / 2)->get();
        $camp = CampDates::current();

        foreach ($campers as $c) {
            foreach ($camp->openDays() as $day) {
                factory(\App\Reservation::class)->create([
                    'camper_id' => $c->id,
                    'user_id' => $c->user_id,
                    'tent_id' => $c->tent_id,
                    'date' => $day->toDateString(),
                ]);
            }
        }
    }
}

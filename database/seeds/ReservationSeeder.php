<?php

use Illuminate\Database\Seeder;
use App\User;
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

        // completely fill a few days for first grade boys
        $user = factory(User::class)->create();
        $firstGraders = factory(Camper::class, 30)->create([
            'user_id' => $user->id,
            'tent_id' => 1,
        ]);

        foreach ($firstGraders as $c) {
            foreach ($camp->openDays()->take(5) as $day) {
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
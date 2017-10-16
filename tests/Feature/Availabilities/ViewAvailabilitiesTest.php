<?php

namespace Tests\Feature\Availabilities;

use Tests\TestCase;
use Carbon\Carbon;
use App\Reservation;
use App\CampDates;
use App\Camper;
use App\User;
use App\Tent;

class ViewAvailabilitiesTest extends TestCase
{
    public function testViewingAvailabilities()
    {
        $user = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $camp = factory(CampDates::class)->create();

        // Reserve first day to avoid weekends
        $reservation = factory(Reservation::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
            'camper_id' => $camper->id,
            'date' => $camp->camp_start,
        ]);

        // next 4th of july
        $July4th = Carbon::now() > Carbon::parse('July 4')
            ? Carbon::parse('July 4')->addYears(1)
            : Carbon::parse('July 4');

        $r = $this->get(route('api.availabilities.index'));
        $r->assertStatus(200)
            ->assertJson([ 0 => [
                'date' => $camp->camp_start,
                'tent_id' => $tent->id,
                'tent_name' => $tent->name,
                'tent_limit' => $tent->camper_limit,
                'campers' => 1,
            ]])
            ->assertJsonMissing([
                'date' => $July4th->toDateString(),
            ])
            ->assertJsonFragment([
                'date' => $camp->camp_end,
            ]);
    }
}

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

        $r = $this->get(route('api.availabilities.index'));
        $r->assertStatus(200)
            ->assertJson([ 0 => [
                'date' => $camp->camp_start,
                'tent_id' => $tent->id,
                'tent_name' => $tent->name,
                'tent_limit' => $tent->camper_limit,
                'campers' => 1,
            ]])
            ->assertJson([ 30 => [
                'date' => $camp->camp_end,
                'tent_id' => $tent->id,
                'tent_name' => $tent->name,
                'tent_limit' => $tent->camper_limit,
                'campers' => 0,
            ]]);
    }
}

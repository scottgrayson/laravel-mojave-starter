<?php

namespace Tests\Feature\Reservations;

use Tests\TestCase;
use Carbon\Carbon;
use App\Reservation;
use App\Camp;
use App\Camper;
use App\User;
use App\Tent;

class ViewReservationsTest extends TestCase
{
    public function testViewingReservations()
    {
        $user = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $reservation = factory(Reservation::class)->create([
            'payment_id' => factory(\App\Payment::class)->create([
            'camp_id' => $camp->id,
            ])->id,
            'camp_id' => $camp->id,
            'tent_id' => $tent->id,
            'user_id' => $user->id,
            'camper_id' => $camper->id,
        ]);

        $this->be($user);
        $r = $this->get(route('api.reservations.index'));
        $r->assertStatus(200)
            ->assertJson([$reservation->toArray()]);
    }

    public function testCannotViewOtherParentsCampers()
    {
        $user = factory(User::class)->create();
        $otheruser = factory(User::class)->create();
        $tent = factory(Tent::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $otheruser->id,
        ]);
        $reservation = factory(Reservation::class)->create([
            'payment_id' => factory(\App\Payment::class)->create([
                'camp_id' => $camp->id,
            ])->id,
            'camp_id' => $camp->id,
            'tent_id' => $tent->id,
            'user_id' => $otheruser->id,
            'camper_id' => $camper->id,
        ]);

        $this->be($user);
        $r = $this->get(route('api.reservations.index'));
        $r->assertStatus(200)
            ->assertJsonMissing([$reservation->toArray()]);
    }
}

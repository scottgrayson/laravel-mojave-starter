<?php

namespace Tests\Feature\Campers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Reservation;
use App\Camper;
use App\User;
use App\Tent;

class CreateReservationTest extends TestCase
{
    public function testReserving()
    {
        $tent = factory(Tent::class)->create();
        $camper = factory(Camper::class)->create(['tent_id' => $tent->id]);
        $user = factory(User::class)->create();

        $this->be($user);

        $r = $this->post(route('checkout.store'), [
            'reservations' => [
            ]
        ]);
    }
}

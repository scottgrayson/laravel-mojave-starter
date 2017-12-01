<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use App\Reservation;
use App\TentLimit;
use App\Payment;
use Cart;
use Carbon\Carbon;

class PayAndReserveTest extends TestCase
{
    public function testPayingAndReservingCamperDays()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);
        $otherCamper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        // make tent limit one for a certain day and try to reserve twice
        $day = $camp->randomCampDay();
        $reservation = factory(Reservation::class)->create([
            'payment_id' => factory(\App\Payment::class)->create([
            'camp_id' => $camp->id,
            ])->id,
            'tent_id' => $tent->id,
            'user_id' => $user->id,
            'camper_id' => $otherCamper->id,
            'date' => $day,
        ]);

        TentLimit::create([
            'tent_id' => $tent->id,
            'date' => $day,
            'camper_limit' => 1,
        ]);

        $this->be($user);

        Cart::add($product, 1, [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'date' => $day,
        ]);

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        $r->assertStatus(200);

        $this->assertEquals($user->reservations->count(), 1);
    }
}

<?php

namespace Tests\Feature\CartItems;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\Reservation;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use Cart;

class CampRatesTest extends TestCase
{
    public function testWeekRateForCartPlusReservedGreaterThan7Days()
    {
        $day = factory(Product::class)->create(['slug' => 'day']);
        $week = factory(Product::class)->create(['slug' => 'week']);
        $full = factory(Product::class)->create(['slug' => 'full']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $start = $camp->camp_start;
        $end = $start->copy()->addDays(7);

        for ($i = $start; $i <= $end; $i->addDays(1)) {
            $reservation = factory(Reservation::class)->create([
                'payment_id' => factory(\App\Payment::class)->create([
                    'camp_id' => $camp->id,
                ])->id,
                'tent_id' => $tent->id,
                'user_id' => $user->id,
                'camper_id' => $camper->id,
                'date' => $camp->randomCampDay()->toDateString(),
            ]);
        }

        $this->be($user);

        $r = $this->json('POST', route('api.cart-items.store'), [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'dates' => [$end->addDays(1)->toDateString()],
        ]);

        $r->assertStatus(200);

        $this->assertEquals(Cart::content()->count(), 1);

        // make sure they get the weekly rate when they reserve more than 7
        $product = Cart::content()->first()->model;
        $this->assertEquals($product->slug, 'week');
    }
}

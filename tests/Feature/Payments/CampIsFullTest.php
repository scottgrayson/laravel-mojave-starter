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

class CampIsFullTest extends TestCase
{
    public function testCampIsFullDuringCheckout()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\CartCampersCompleted::class
        ]);

        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create(['camper_limit' => 0]);
        $tent2 = factory(Tent::class)->create(['camper_limit' => 0]);
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);
        $otherCamper = factory(Camper::class)->create([
            'tent_id' => $tent2->id,
            'user_id' => $user->id,
        ]);

        $day = $camp->randomCampDay();
        $this->be($user);

        foreach (Camper::all() as $c) {
            foreach ($camp->openDays() as $d) {
                Cart::add($product, 1, [
                    'camper_id' => $c->id,
                    'camp_id' => $camp->id,
                    'tent_id' => $c->tent_id,
                    'product' => $product->slug,
                    'date' => $d,
                ]);
            }
        }

        $r = $this->get(route('checkout.index'));

        $r->assertStatus(302);

        $this->assertEquals(0, Cart::count());

        $r->assertRedirect(route('cart.index'));

        $r->assertSessionHas('flash_notification');
    }

    public function testCampIsFullDuringPayment()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\CartCampersCompleted::class
        ]);

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
            'camp_id' => $camp->id,
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
            'camp_id' => $camp->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'date' => $day,
        ]);

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        $r->assertStatus(400);

        $this->assertEquals(0, Cart::count());

        $this->assertEquals($user->reservations->count(), 1);
    }
}

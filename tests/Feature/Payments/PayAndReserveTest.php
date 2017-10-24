<?php

namespace Tests\Feature\CartItems;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\CampDates;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use Cart;

class PayAndReserveTest extends TestCase
{
    public function testPayingAndReservingCamperDays()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(CampDates::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        Cart::add($product, 1, [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
        ]);

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $this->assertEquals($user->reservations->count(), 1);
    }
}

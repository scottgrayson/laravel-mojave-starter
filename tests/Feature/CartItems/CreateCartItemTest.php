<?php

namespace Tests\Feature\CartItems;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\CampDates;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;

class CreateCartItemTest extends TestCase
{
    public function testAddingReservationToCart()
    {
        $product = factory(Product::class)->make(['slug' => 'day']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(CampDates::class)->create();
        $camper = factory(Camper::class)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        $r = $this->json('POST', route('cart-items.store'), [
                'camper_id' => $camper->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $camp->randomCampDay(),
        ]);

        $r->assertStatus(200);

        $this->assertEquals(Cart::content()->count(), 1);
    }
}

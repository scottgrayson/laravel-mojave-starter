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

class StoreCartItemsTest extends TestCase
{
    public function testAddingAndRemovingReservationToCart()
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

        $r = $this->json('POST', route('api.cart-items.store'), [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'dates' => [$camp->randomCampDay()->toDateString()],
        ]);

        $r->assertStatus(200);

        $this->assertEquals(Cart::content()->count(), 1);

        // now, remove it
        $rowId = Cart::content()->first()->rowId;

        $r = $this->json('DELETE', route('api.cart-items.destroy', [$rowId]));

        $r->assertStatus(200);

        $this->assertEquals(Cart::content()->count(), 0);
    }

    // Replace dates for camper with new ones
    public function testResettingCamperReservations()
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

        foreach ($camp->openDays() as $day) {
            Cart::add($product, 1, [
                'camper_id' => $camper->id,
                'tent_id' => $tent->id,
                'date' => $day->toDateString()
            ]);
        }

        $this->assertEquals(Cart::content()->count(), $camp->openDays()->count());

        $r = $this->json('POST', route('api.cart-items.store'), [
            'camper_id' => $camper->id,
            'tent_id' => $tent->id,
            'product' => $product->slug,
            'dates' => [
                $camp->randomCampDay()->toDateString(),
                $camp->randomCampDay()->toDateString()
            ],
        ]);

        $r->assertStatus(200);

        $this->assertEquals(Cart::content()->count(), 2);
    }
}

<?php

namespace Tests\Feature\CartItems;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use Cart;

class FullCampInCartTest extends TestCase
{
    public function testExpandingFullCampToEveryDay()
    {
        $product = factory(Product::class)->create(['slug' => 'full']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
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

        $r = $this->get(route('calendar.index'));

        $r->assertViewHas('reservations');
    }
}

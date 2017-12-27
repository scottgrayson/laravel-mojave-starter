<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\Camper;
use App\Product;
use App\User;
use App\Tent;
use App\Payment;
use Cart;
use App\Invoice;
use Carbon\Carbon;

class CreateInvoiceTest extends TestCase
{
    public function testCreatingInvoice()
    {
        $product = factory(Product::class)->create(['slug' => 'day']);
        $registrationFee = factory(Product::class)->create(['slug' => 'registration-fee']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
        $camper = factory(Camper::class, 3)->create([
            'tent_id' => $tent->id,
            'user_id' => $user->id,
        ]);

        $this->be($user);

        foreach ($camper as $c) {
            Cart::add($product, 1, [
                'camper_id' => $c->id,
                'tent_id' => $tent->id,
                'product' => $product->slug,
                'date' => $camp->camp_start->toDateString(),
            ]);
        }

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $this->assertEquals($user->reservations->count(), 3);

        // Assert work party fee NOT paid
        $registrationPayment = Payment::where('user_id', $user->id)
            ->where('type', 'registration_fee')
            ->count();

        $this->assertEquals($registrationPayment, 0);
    }
}
?>

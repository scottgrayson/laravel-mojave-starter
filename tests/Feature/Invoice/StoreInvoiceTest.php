<?php

namespace Tests\Feature\Invoice;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Tent;
use App\Camp;
use App\Camper;
use App\Product;
use App\Invoice;
use App\Mail\Invoice as InvoiceEmail;

class StoreInvoiceTest extends TestCase
{
    public function testStoringInvoice()
    {
        Mail::fake();

        $product = factory(Product::class)->create(['slug' => 'day']);
        $tent = factory(Tent::class)->create();
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();
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

        $r = $this->post(route('api.payments.store'), [
            'nonce' => 'fake-valid-nonce',
        ]);

        Mail::assertSent(InvoiceEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        //$this->feedback($r);
        $r->assertStatus(200);
    }
}

<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\User;
use App\Payment;
use Braintree_Transaction;

class RefundPaymentTest extends TestCase
{
    use WithoutMiddleware;

    public function testRefunding()
    {
        $user = factory(User::class)->create();
        $camp = factory(Camp::class)->create();

        $result = Braintree_Transaction::sale([
            'amount' => '10.00',
            'paymentMethodNonce' => 'fake-valid-nonce',
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        $payment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'transaction' => $result->transaction->id,
            'type' => 'registration_fee',
            'amount' => '10.00',
        ]);

        $this->be($user);

        $r = $this->post(route('api.payments.delete', $payment->id));

        //$this->feedback($r);
        $r->assertStatus(200);

        $this->assertEquals($payment->fresh()->refunded, true);

        $transaction = Braintree_Transaction::find($payment->transaction);

        $this->assertEquals(true, $transaction->refunded);
    }
}

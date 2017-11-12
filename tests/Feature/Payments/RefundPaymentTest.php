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
    // @medium

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

        $r = $this->delete(route('admin.payments.destroy', $payment->id));

        //$this->feedback($r);
        $r->assertStatus(302);

        $this->assertNotNull($payment->fresh()->refunded);

        $result = Braintree_Transaction::find($payment->transaction);

        $refundedOrVoided = in_array($result->status, ['voided', 'refunded']);

        $this->assertTrue($refundedOrVoided);
    }
}

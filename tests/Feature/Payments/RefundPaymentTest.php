<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\User;
use App\Payment;
use Braintree_Transaction;
use Braintree\Test\Transaction;

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

        Transaction::settle($result->transaction->id);

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

        $refundDate = $payment->fresh()->refunded;
        $this->assertNotNull($refundDate);

        $result = Braintree_Transaction::find($payment->transaction);

        $this->assertNotNull($result->refundId);
    }

    public function testVoiding()
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

        $refundDate = $payment->fresh()->refunded;
        $this->assertNotNull($refundDate);

        $result = Braintree_Transaction::find($payment->transaction);

        $this->assertEquals($result->status, 'voided');
    }

    // Next 2 tests for payments that have already been refunded through braintree dash

    public function testAlreadyRefunded()
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

        Transaction::settle($result->transaction->id);
        Braintree_Transaction::refund($result->transaction->id);

        $payment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'transaction' => $result->transaction->id,
            'type' => 'registration_fee',
            'amount' => '10.00',
        ]);

        $payment->refund();

        $refundDate = $payment->fresh()->refunded;
        $this->assertNotNull($refundDate);
    }

    public function testAlreadyVoided()
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

        Braintree_Transaction::void($result->transaction->id);

        $payment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'transaction' => $result->transaction->id,
            'type' => 'registration_fee',
            'amount' => '10.00',
        ]);

        $payment->refund();

        $refundDate = $payment->fresh()->refunded;
        $this->assertNotNull($refundDate);
    }
}

<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\User;
use App\Payment;
use Braintree_Transaction;

class RefundMultipleTest extends TestCase
{
    // @medium

    use WithoutMiddleware;

    public function testRefunding()
    {
        $users = factory(User::class, 3)->create();
        $camp = factory(Camp::class)->create();

        foreach ($users as $user) {
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
        }

        $this->be($user);

        $r = $this->json('POST', route('admin.payments.refund-multiple'), [ 'emails' => $emails ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $r->assertJsonFragment(['already_refunded' => []]);
        $r->assertJsonFragment(['refunded' => []]);
        $r->assertJsonFragment(['email_not_found' => []]);
        $r->assertJsonFragment(['payment_not_found' => []]);
    }
}

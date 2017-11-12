<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Camp;
use App\User;
use App\Payment;
use Braintree_Transaction;
use Braintree\Test\Transaction;

class RefundMultipleTest extends TestCase
{
    // @medium

    use WithoutMiddleware;

    public function testRefunding()
    {
        $camp = factory(Camp::class)->create();

        $usersWithRefund = factory(User::class, 1)->create()
            ->each(function ($user) use ($camp) {
                $this->createPayment($user, $camp, true);
            })
            ->pluck('email');

        $usersWithPayment = factory(User::class, 2)->create()
            ->each(function ($user) use ($camp) {
                $this->createPayment($user, $camp, false);
            })
            ->pluck('email');

        $usersWithoutPayment = factory(User::class, 3)->create()->pluck('email');

        $emails = User::pluck('email')->push('junk@email.com')->implode(',');

        $r = $this->json('POST', route('admin.payments.refund-multiple'), [ 'emails' => $emails ]);

        //$this->feedback($r);
        $r->assertStatus(200);

        $r->assertJsonFragment(['already_refunded' => $usersWithRefund]);
        $r->assertJsonFragment(['refunded' => $usersWithPayment]);
        $r->assertJsonFragment(['email_not_found' => ['junk@email']]);
        $r->assertJsonFragment(['payment_not_found' => $usersWithoutPayment]);
    }

    protected function createPayment($user, $camp, $refunded = false)
    {
        $result = Braintree_Transaction::sale([
            'amount' => '10.00',
            'paymentMethodNonce' => 'fake-valid-nonce',
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        Transaction::settle($result->transaction->id);
        if ($refunded) {
            Braintree_Transaction::refund($result->transaction->id);
        }

        $payment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'transaction' => $result->transaction->id,
            'type' => 'registration_fee',
            'amount' => '10.00',
        ]);
    }
}

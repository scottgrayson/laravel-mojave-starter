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

    public function testRefunding()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\RoleMiddleware::class
        ]);

        $camp = factory(Camp::class)->create();

        $usersWithRefund = factory(User::class, 1)->create()
            ->each(function ($user) use ($camp) {
                $this->createPayment($user, $camp, true);
            })
            ->pluck('email');

        $usersWithPayment = factory(User::class, 1)->create()
            ->each(function ($user) use ($camp) {
                $this->createPayment($user, $camp, false);
            })
            ->pluck('email');

        $usersWithoutPayment = factory(User::class, 1)->create()->pluck('email');

        $emails = User::pluck('email')->push('junk@email.com')->implode(',');

        $r = $this->post(route('admin.refunds.store'), [ 'emails' => $emails ]);

        $r->assertStatus(302);

        $r->assertSessionHas('refund_results', [
            'already_refunded' => $usersWithRefund,
            'error_refunding' => collect([]),
            'refunded' => $usersWithPayment,
            "email_not_found" => collect(["junk@email.com"]),
            'payment_not_found' => $usersWithoutPayment,
        ]);
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
        $payment = factory(Payment::class)->create([
            'user_id' => $user->id,
            'camp_id' => $camp->id,
            'transaction' => $result->transaction->id,
            'type' => 'registration_fee',
            'amount' => '10.00',
        ]);

        if ($refunded) {
            $payment->refund();
        }
    }
}

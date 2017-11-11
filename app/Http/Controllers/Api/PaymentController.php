<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CartHelper;
use App\Camp;
use App\Product;
use App\Payment;
use Cart;
use App\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree_Configuration;
use Braintree_Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        Braintree_Configuration::environment(config('services.braintree.env'));
        Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
        Braintree_Configuration::publicKey(config('services.braintree.public_key'));
        Braintree_Configuration::privateKey(config('services.braintree.private_key'));
    }

    public function store(Request $request)
    {
        $camp = Camp::current();

        if (!$camp || Cart::content()->isEmpty()) {
            abort(400);
        }

        // Pay Registration Fee
        if (!request()->user()->hasPaidRegistrationFee() && Cart::content()->count() >= 5) {
            $registrationFee = Product::where('slug', 'registration-fee')->firstOrFail();

            $result = Braintree_Transaction::sale([
                'amount' => $registrationFee->price,
                'paymentMethodNonce' => request('nonce'),
                'options' => [
                    'submitForSettlement' => true,
                ]
            ]);

            if ($result->success) {
                // See $result->transaction for details
                $payment = Payment::create([
                    'user_id' => auth()->user()->id,
                    'camp_id' => $camp->id,
                    'transaction' => $result->transaction->id,
                    'amount' => $result->transaction->amount,
                    'type' => 'registration_fee',
                ]);
            } else {
                // Handle errors
                \Log::error($result);
                abort(400);
            }
        }

        // Pay For Reservation
        $result = Braintree_Transaction::sale([
            'amount' => CartHelper::total(),
            'paymentMethodNonce' => request('nonce'),
            'options' => [
                'submitForSettlement' => true,
            ]
        ]);

        if ($result->success) {
            // See $result->transaction for details
            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'camp_id' => $camp->id,
                'transaction' => $result->transaction->id,
                'amount' => $result->transaction->amount,
                'type' => 'reservation',
            ]);
        } else {
            // Handle errors
            \Log::error($result);
            abort(400);
        }


        foreach (CartHelper::pendingReservations() as $i) {
            Reservation::create(array_merge($i, [
                'payment_id' => $payment->id,
            ]));
        }

        Cart::destroy();

        return 'Payment Successful';
    }
}

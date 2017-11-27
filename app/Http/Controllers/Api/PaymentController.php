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

use App\Mail\Invoice;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $camp = Camp::current();

        if (!$camp || Cart::content()->isEmpty()) {
            abort(400);
        }
        // CreateOrUpdate Customer
        if (!request()->user()->isCustomer() && !request('nonce')) {
            abort(400, 'Payment method is required.');
        } elseif (request('nonce')) {
            // update or create customer
            try {
                request()->user()->setPaymentMethod(request('nonce'));
            } catch (\Exception $e) {
                \Log::error($e);
                abort(400, 'Error setting payment method.');
            }
        }

        // Pay Registration Fee
        if (!request()->user()->hasPaidRegistrationFee() && Cart::content()->count() >= 5) {
            $registrationFee = Product::where('slug', 'registration-fee')->firstOrFail();

            $result = request()->user()->charge($registrationFee->price, 'fee');

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
                abort(400, 'Failed charging for registration fee');
            }
        }

        // Pay For Reservation
        $total = CartHelper::totalWithoutFees();
        $result = request()->user()->charge($total, 'camp');

        if ($result->success) {
            // See $result->transaction for details
            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'camp_id' => $camp->id,
                'transaction' => $result->transaction->id,
                'amount' => $result->transaction->amount,
                'type' => 'reservations',
            ]);
        } else {
            // Handle errors
            \Log::error($result);
            abort(400, 'Failed charging for reservations');
        }

        $reservations = collect();

        foreach (CartHelper::pendingReservations() as $i) {
            $reservation = Reservation::create(array_merge($i, [
                'payment_id' => $payment->id,
            ]));
            $reservations->push($reservation);
        }

        $reservations = $reservations->groupBy('camper_id');

        Mail::to($request->user()->email)->send(new Invoice($total, $request->user(), $reservations, $payment));

        Cart::destroy();

        return 'Payment Successful';
    }
}

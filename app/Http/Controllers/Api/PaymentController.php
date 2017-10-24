<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CartHelper;
use App\Product;
use App\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // TODO verify amount == CartHelper::total()

        try {
            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'nonce' => request('nonce'),
            ]);
        } catch (\Exception $e) {
            dd($e); //TODO remove
            abort(400);
        }

        foreach (CartHelper::pendingReservations() as $i) {
            dd($i);
            Reservation::create([
                'camper_id' => $c->id,
                'user_id' => auth()->user()->id,
                'tent_id' => $c->tent_id,
                'date' => $day->toDateString(),
            ]);
        }

        return 'Payment Successful';
    }
}

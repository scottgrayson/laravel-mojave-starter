<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Camp;
use App\User;
use App\Payment;

class RefundController extends Controller
{
    public function index($id)
    {
        $camp = Camp::current();

        $refunds = Payment::where('camp_id', $camp->id)
            ->whereNotNull('refunded')
            ->paginate();

        return view('admin.refunds.index', [
            'refunds' => $refunds,
            'reservations' => $reservations,
        ]);
    }

    public function store()
    {
        $camp = Camp::current();
        $emails = explode(',', request('emails'));

        $users = User::whereIn('email', $emails)->get();

        $payments = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->get();

        $toRefund = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->whereNull('refunded')
            ->get();

        $refundedPayments = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->whereNotNull('refunded')
            ->get();


        $emailNotFound = collect($emails)->diff($users->pluck('email'))->values();
        $paymentNotFound = $users->whereNotIn('id', $payments->pluck('user_id'))
            ->pluck('email');
        $alreadyRefunded = $users->whereIn('id', $refundedPayments->pluck('user_id'))
            ->pluck('email');

        $success = [];
        $fail = [];

        foreach ($toRefund as $payment) {
            try {
                $payment->refund();
                $success []= $payment;
            } catch (\Exception $e) {
                $fail []= $payment;
            }
        }

        $errorRefunding = $users->whereIn('id', collect($fail)->pluck('user_id'))->pluck('email');
        $refunded = $users->whereIn('id', collect($success)->pluck('user_id'))->pluck('email');

        return [
            'email_not_found' => $emailNotFound,
            'payment_not_found' => $paymentNotFound,
            'already_refunded' => $alreadyRefunded,
            'refunded' => $refunded,
            'error_refunding' => $errorRefunding,
        ];
    }
}

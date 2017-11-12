<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Camp;
use App\User;
use App\Payment;
use App\Http\Requests\RefundRequest;
use SEO;

class RefundController extends Controller
{
    // Table and create form in one
    public function index()
    {
        $camp = Camp::current();

        SEO::setTitle('Refunds');
        SEO::setDescription('Refunds');

        $fields = $this->getFieldsFromRules(new RefundRequest);

        $refunds = Payment::where('camp_id', $camp->id)
            ->whereNotNull('refunded')
            ->where('type', 'registration_fee')
            ->paginate();

        return view('admin.refunds.index', [
            'refunds' => $refunds,
            'camp' => $camp,
            'fields' => $fields,
        ]);
    }

    public function store()
    {
        $camp = Camp::current();
        $emails = explode(',', str_replace(' ', '', request('emails')));

        $users = User::whereIn('email', $emails)->get();

        $payments = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->where('type', 'registration_fee')
            ->get();

        $toRefund = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->where('type', 'registration_fee')
            ->whereNull('refunded')
            ->get();

        $refundedPayments = Payment::where('camp_id', $camp->id)
            ->whereIn('user_id', $users->pluck('id'))
            ->where('type', 'registration_fee')
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

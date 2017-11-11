<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class PaymentController extends CrudController
{
    protected $model = \App\Payment::class;
    protected $slug = 'payments';
    protected $columns = [
        'id',
        'user_id',
        'type',
        'transaction',
        'amount',
        'created_at',
    ];

    public function show($id)
    {
        $payment = $this->model::findOrFail($id);

        $reservations = \App\Reservation::with('camper', 'tent')
            ->where('payment_id', $id)
            ->get();

        return view('admin.payments.show', [
            'payment' => $payment,
            'reservations' => $reservations,
        ]);
    }
}

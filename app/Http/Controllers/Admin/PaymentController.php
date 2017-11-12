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

    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);

        try {
            $item->refund();
            flash($this->singular . ' deleted.')->success();
        } catch (\Exception $e) {
            \Log::info($e);
            flash("Could not delete $this->singular.")->error();
        }

        if (request()->is('admin*')) {
            return redirect(route("admin.$this->slug.index"));
        }
        return redirect(route("$this->slug.index"));
    }
}

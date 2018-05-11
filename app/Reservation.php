<?php

namespace App;

class Reservation extends Model
{
    protected $dates = [
        'date'
    ];

    protected $appends = [
        'invoice',
    ];

    public function camper()
    {
        return $this->belongsTo(\App\Camper::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }

    public function payment()
    {
        return $this->belongsTo(\App\Payment::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(
            \App\Invoice::class,
            'invoice_reservation',
            'reservation_id',
            'invoice_id'
        )->withTimestamps();
    }

    public function getInvoiceAttribute()
    {
        return $this->invoices->first();
    }
}

<?php

namespace App;

class Invoice extends Model
{
    protected $dates = [
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(
            \App\Reservation::class,
            'invoice_reservation',
            'invoice_id',
            'reservation_id'
        )->withTimestamps();
    }
}

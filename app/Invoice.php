<?php

namespace App;

use App\Camper;

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

    public function campers()
    {
        return $this->hasManyThrough(
            \App\Camper::class,
            \App\Reservation::class,
            'camper_id',
            'id'
        );
    }
}

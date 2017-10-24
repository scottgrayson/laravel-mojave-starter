<?php

namespace App;

class Payment extends Model
{
    public function reservations()
    {
        return $this->belongsTo(\App\Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

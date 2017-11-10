<?php

namespace App;

use App\Camp;

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

    public function camp()
    {
        return $this->belongsTo(\App\Camp::class);
    }
}

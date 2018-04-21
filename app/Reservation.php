<?php

namespace App;

class Reservation extends Model
{
    protected $dates = [
        'date'
    ];

    public function camper()
    {
        return $this->belongsTo(\App\Camp::class);
    }

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
}

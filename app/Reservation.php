<?php

namespace App;

class Reservation extends Model
{
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
}

<?php

namespace App;

class Reservation extends Model
{
    public function camper()
    {
        return $this->belongsTo(\App\Camper::class);
    }
}

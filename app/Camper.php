<?php

namespace App;

class Camper extends Model
{
    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

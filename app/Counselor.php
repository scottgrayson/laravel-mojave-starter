<?php

namespace App;

class Counselor extends Model
{
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }
}

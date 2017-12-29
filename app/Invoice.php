<?php

namespace App;

class Invoice extends Model
{
    protected $dates = [
        'createad_at'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(\App\Reservation::class)
            ->withTimestamps();
    }
}

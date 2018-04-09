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
        $campers = Camper::whereHas('reservations', function($query) {
            return \DB::table('invoice_reservation')
                ->where('invoice_id', $this->id);
        })->get(); 

        return $campers;
    }
}

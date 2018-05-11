<?php

namespace App;

use DB;
use App\Camper;

class Invoice extends Model
{
    protected $dates = [
        'created_at',
    ];

    protected $appends = [
        'totalUSD',
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
        return $this->reservations()
            ->with('camper')
            ->groupBy('reservations.camper_id')
            ->get()
            ->pluck('camper');
    }

    public function lineItems()
    {
        $reservationIds = $this->reservations()
            ->pluck('reservations.id');

        return Reservation::with(['camper', 'payment', 'tent'])
            ->whereIn('id', $reservationIds)
            ->select([
                'camper_id',
                'tent_id',
                DB::raw('COUNT(reservations.id) as day_count'),
            ])
            ->groupBy('camper_id')
            ->get();
    }

    public function getTotalUSDAttribute()
    {
        return number_format($this->total, 2);
    }
}

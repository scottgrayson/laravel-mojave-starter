<?php

namespace App\Helpers;

use Cart;
use App\Product;
use App\CampDates;

class CartHelper
{
    public static function reservationsByCamper()
    {
        $cart = Cart::content();

        $workPartyFee = Product::where('slug', 'work-party-fee')->first();

        $campLength = CampDates::current()->openDays()->count();

        $campers = auth()->user()->campers
            ->map(function ($camper) use ($cart) {
                $days = $cart->filter(function ($i) use ($camper) {
                    return $i->options->camper_id == $camper->id;
                });

                if ($days->isEmpty()) {
                    return false;
                }

                $rate = $days->first()->model->price;

                return (object) [
                    'name' => $camper->name,
                    'qty' => $days->count(),
                    'rate' => $rate,
                    'subtotal' => $days->count() * $rate,
                    'camper_id' => $camper->id,
                ];
            })
            ->filter(function ($camper) {
                return $camper;
            });

        $fees = $workPartyFee ? collect([
            (object) [
                'name' => $workPartyFee->name,
                'qty' => 1,
                'rate' => $workPartyFee->price,
                'subtotal' => $workPartyFee->price,
                'workPartyNotice' => $workPartyFee->description,
            ]
        ]) : collect([]);

        return $campers->merge($fees);
    }

    public static function total()
    {
        return static::reservationsByCamper()->sum('subtotal');
    }

    public static function pendingReservations()
    {
        return Cart::content()->map(function ($i) {
            return [
                'user_id' => auth()->user()->id,
                'camper_id' => $i->options->camper_id,
                'tent_id' => $i->options->tent_id,
                'date' => $i->options->date,
            ];
        })->toArray();
    }
}

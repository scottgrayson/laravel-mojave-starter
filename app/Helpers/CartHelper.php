<?php

namespace App\Helpers;

use Cart;
use App\Product;
use App\Camp;

class CartHelper
{
    public static function reservationsByCamper()
    {
        $cart = Cart::content();

        $registrationFee = Product::where('slug', 'registration-fee')->first();

        $campLength = Camp::current()->openDays()->count();

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
                    'name' => $camper->first_name . ' ' . $camper->last_name,
                    'qty' => $days->count(),
                    'rate' => $rate,
                    'subtotal' => $days->count() * $rate,
                    'camper_id' => $camper->id,
                ];
            })
            ->filter(function ($camper) {
                return $camper;
            });

        $needsToPayRegistrationFee = !request()->user()->hasPaidRegistrationFee()
            && $campers->contains(function ($c) {
                return $c->qty >= 5;
            });

        $fees = $needsToPayRegistrationFee && $registrationFee ? collect([
            (object) [
                'name' => $registrationFee->name,
                'qty' => 1,
                'rate' => $registrationFee->price,
                'subtotal' => $registrationFee->price,
                'feeNotice' => $registrationFee->description,
            ]
        ]) : collect([]);

        return $campers->merge($fees);
    }

    public static function total()
    {
        return static::reservationsByCamper()->sum('subtotal');
    }

    public static function totalWithoutFees()
    {
        return static::reservationsByCamper()
            ->filter(function ($i) {
                return !isset($i->feeNotice);
            })
            ->sum('subtotal');
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

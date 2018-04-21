<?php

namespace App\Helpers;

use Cart;
use App\Tent;
use App\TentLimit;
use App\Reservation;
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
                'camp_id' => $i->options->camp_id,
                'tent_id' => $i->options->tent_id,
                'date' => $i->options->date,
            ];
        })->toArray();
    }

    // This could be slow. dont run it often.
    public static function outOfStock()
    {
        $outOfStock = [];

        foreach (Cart::content() as $i) {
            $tent = Tent::findOrFail($i->options->tent_id);

            $numReserved = Reservation::where('date', $i->options->date)
                ->where('tent_id', $tent->id)
                ->count();

            $limitOverride = TentLimit::where('date', $i->options->date)
                ->where('tent_id', $tent->id)
                ->first();

            $limit = $limitOverride ? $limitOverride->camper_limit : $tent->camper_limit;

            if ($numReserved >= $limit) {
                $outOfStock []= ['date' => $i->options->date, 'tent' => $tent->name];

                Cart::remove($i->rowId);
            }
        }

        return count($outOfStock) ? $outOfStock : false;
    }

    public static function incompleteCampers()
    {
        return request()->user()->campers
            ->filter(function ($camper) {
                $inCart = Cart::content()->contains(function ($item) use ($camper) {
                    return isset($item->options['camper_id']) && $item->options['camper_id'] == $camper->id;
                });

                return $inCart && $camper->registration_complete;
            });
    }
}

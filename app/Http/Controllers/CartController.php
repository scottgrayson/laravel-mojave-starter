<?php

namespace App\Http\Controllers;

use Cart;
use SEO;
use App\Product;
use App\CampDates;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        SEO::setTitle('My Cart');

        $cart = Cart::content();

        $workPartyFee = Product::where('slug', 'work-party-fee')->first();

        $rates = Product::whereIn('slug', ['day', 'week', 'full'])->get();
        $ratesArr = $rates->pluck('price', 'slug');

        $campLength = CampDates::current()->openDays()->count();

        $campers = auth()->user()->campers
            ->map(function ($camper) use ($cart, $ratesArr, $campLength) {
                $days = $cart->filter(function ($i) use ($camper) {
                    return $i->options->camper_id == $camper->id;
                })->count();

                // TODO do price calculation with discounts for # days > X
                if ($days == $campLength) {
                    $rate = $ratesArr['full'];
                } elseif ($days >= 5) {
                    $rate = $ratesArr['week'];
                } else {
                    $rate = $ratesArr['day'];
                }

                return (object) [
                    'name' => $camper->name,
                    'qty' => $days,
                    'rate' => $rate,
                    'subtotal' => $days * $rate,
                    'camper_id' => $camper->id,
                ];
            })
            ->filter(function ($camper) {
                return $camper->qty > 0;
            });

        $fees = collect([
            (object) [
                'name' => $workPartyFee->name,
                'qty' => 1,
                'rate' => $workPartyFee->price,
                'subtotal' => $workPartyFee->price,
                'workPartyNotice' => $workPartyFee->description,
            ]
        ]);

        $items = $campers->merge($fees);

        $total = $items->sum('subtotal');

        return view('cart.index', [
            'noReservations' => $campers->isEmpty(),
            'items' => $items,
            'total' => $total,
            'rates' => $rates,
            'workPartyFee' => $workPartyFee,
        ]);
    }

    public function destroy()
    {
        try {
            Cart::destroy();
        } catch (\Exceptions $e) {
            flash('There was a problem resetting your cart.')->error();
            return redirect()->back();
        }

        flash('Your cart is now empty.')->success();

        return redirect()->back();
    }
}

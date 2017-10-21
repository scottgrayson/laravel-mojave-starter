<?php

namespace App\Http\Controllers;

use Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {

        $cart = Cart::content();
        $campers = auth()->user()->campers
            ->map(function ($camper) use ($cart) {
                $days = $cart->filter(function ($i) use ($camper) {
                    return $i->options->camper_id == $camper->id;
                })->count();

                // TODO do price calculation with discounts for # days > X
                $rate = 50;

                return (object) [
                    'camper' => $camper,
                    'days' => $days,
                    'rate' => $rate,
                    'price' => $days * $rate,
                ];
            })
            ->filter(function ($camper) {
                return $camper->days > 0;
            });

        $total = $campers->sum('price');

        return view('cart.index', [
            'items' => $campers,
            'total' => $total,
        ]);
    }
}

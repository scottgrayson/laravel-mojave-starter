<?php

namespace App\Http\Controllers;

use Cart;
use App\Helpers\CartHelper;
use SEO;
use App\Product;
use App\Camp;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        SEO::setTitle('My Cart');

        $workPartyFee = Product::where('slug', 'work-party-fee')->first();

        $items = CartHelper::reservationsByCamper();

        $total = $items->sum('subtotal');

        $rates = Product::whereIn('slug', ['day', 'week', 'full'])->get();

        return view('cart.index', [
            'noReservations' => Cart::content()->isEmpty(),
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

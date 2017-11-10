<?php

namespace App\Http\Controllers\Api;

use Cart;
use App\Product;
use App\Camp;
use App\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index(Request $request)
    {
        return $this->cartResponse();
    }

    public function store(CartItemRequest $request)
    {
        // remove existing cart_items for camper_id
        $existing = Cart::content()
            ->filter(function ($i) use ($request) {
                return $i->options->has('camper_id')
                    && $i->options->camper_id == $request->input('camper_id');
            })
            ->map(function ($i) {
                Cart::remove($i->rowId);
            });

        $camp = Camp::current();
        $campLength = $camp->openDays()->count();

        $numReserved = Reservation::where('camper_id', request('camper_id'))
            ->whereDate('date', '>=', $camp->camp_start->toDateString())
            ->count();

        $numDays = count(request('dates')) + $numReserved;

        if ($numDays == $campLength) {
            $product = Product::where('slug', 'full')->first();
        } elseif ($numDays >= 5) {
            $product = Product::where('slug', 'week')->first();
        } else {
            $product = Product::where('slug', 'day')->first();
        }

        foreach (request('dates') as $date) {
            Cart::add($product, 1, [
                'camper_id' => request('camper_id'),
                'tent_id' => request('tent_id'),
                'date' => $date,
            ]);
        }

        return $this->cartResponse();
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return $this->cartResponse();
    }

    protected function cartResponse()
    {
        $arr = [];

        foreach (Cart::content() as $item) {
            $arr []= $item->options;
        }

        return $arr;
    }
}

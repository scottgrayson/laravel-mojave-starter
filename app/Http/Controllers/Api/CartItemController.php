<?php

namespace App\Http\Controllers\Api;

use Cart;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function store(CartItemRequest $request)
    {
        $product = Product::findBySlug(request('product'));

        if (!$product) {
            abort(404);
        }

        Cart::add($product, 1, [
            'camper_id' => request('camper_id'),
            'tent_id' => request('tent_id'),
            'date' => request('date'),
        ]);

        return 'Added to cart.';
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return 'Removed from cart.';
    }
}

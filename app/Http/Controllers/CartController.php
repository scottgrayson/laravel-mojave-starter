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
        return view('cart.index', [
            'items' => Cart::content(),
        ]);
    }
}

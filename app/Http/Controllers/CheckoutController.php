<?php

namespace App\Http\Controllers;

use Cart;
use App\Helpers\CartHelper;
use SEO;
use App\Product;
use App\Camp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree_ClientToken;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        SEO::setTitle('Checkout');

        if (Cart::content()->isEmpty()) {
            return redirect(route('cart.index'));
        }

        $amount = CartHelper::total();

        if (request()->user()->isCustomer()) {
            $clientToken = Braintree_ClientToken::generate([
                'customerId' => request()->user()->braintree_customer
            ]);
        } else {
            $clientToken = Braintree_ClientToken::generate();
        }

        return view('checkout.index', [
            'amount' => $amount,
            'clientToken' => $clientToken,
        ]);
    }
}
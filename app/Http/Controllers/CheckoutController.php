<?php

namespace App\Http\Controllers;

use Cart;
use SEO;
use App\Product;
use App\CampDates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree_Configuration;
use Braintree_ClientToken;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Braintree_Configuration::environment(config('services.braintree.env'));
        Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
        Braintree_Configuration::publicKey(config('services.braintree.public_key'));
        Braintree_Configuration::privateKey(config('services.braintree.private_key'));
    }

    public function index(Request $request)
    {
        SEO::setTitle('Checkout');

        $cart = Cart::content();

        if ($cart->isEmpty()) {
            return redirect(route('cart.index'));
        }

        // TODO fix this
        //$clientToken = Braintree_ClientToken::generate();
        $clientToken = '';

        return view('checkout.index', [
            'cart' => $cart,
            'clientToken' => $clientToken,
        ]);
    }

    public function store()
    {
        try {
            Cart::destroy();
        } catch (\Exceptions $e) {
            flash('There was a problem resetting your cart.')->error();
            return redirect()->back();
        }

        flash('Payment successful. Camp dates reserved.')->success();

        return redirect()->back();
    }
}

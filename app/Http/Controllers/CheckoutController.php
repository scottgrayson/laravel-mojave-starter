<?php

namespace App\Http\Controllers;

use Cart;
use App\Helpers\CartHelper;
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

        if (Cart::content()->isEmpty()) {
            return redirect(route('cart.index'));
        }

        $amount = CartHelper::total();

        // TODO fix this
        //$clientToken = Braintree_ClientToken::generate();
        $clientToken = '';

        return view('checkout.index', [
            'amount' => $amount,
            'clientToken' => $clientToken,
        ]);
    }
}

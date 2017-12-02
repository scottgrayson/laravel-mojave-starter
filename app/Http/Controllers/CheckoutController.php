<?php

namespace App\Http\Controllers;

use Cart;
use App\Helpers\CartHelper;
use SEO;
use App\Product;
use App\Camp;
use Illuminate\Support\Facades\Mail;
use App\Mail\Invoice;
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

        if ($outOfStock = CartHelper::outOfStock()) {
            $removedString = $this->outOfStockString($outOfStock);
            flash("The following days are not available and have been removed from your cart: ${removedString}")->error();

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

    protected function outOfStockString($arr)
    {
        $tent = collect($arr)->groupBy('tent');

        $string = '';

        foreach ($tent as $t => $days) {
            $dayString = $days->map(function ($d) {
                return $d['date']->format('Y-m-d');
            })->implode(', ');

            $string .= $t . ': ' . $dayString . '. ';
        }

        return $string;
    }
}

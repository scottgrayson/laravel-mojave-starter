<?php

namespace App\Http\Controllers\Api;

use Cart;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());

        return 'Payment Successful';
    }
}

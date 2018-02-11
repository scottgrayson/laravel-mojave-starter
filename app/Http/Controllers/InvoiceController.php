<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = $request->user()->invoices()->paginate(15);

        return view('invoices.index', ['invoices' => $invoices]);
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);

        return view('invoices.show', ['invoice' => $invoice]);
    }
}
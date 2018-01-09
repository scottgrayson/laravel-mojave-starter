<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use Illuminate\Http\Request;

use App\Http\Controllers\CrudController;

class InvoiceController extends CrudController
{
    protected $model = Invoice::class;
    protected $slug = 'invoices';
    protected $formRequest = \App\Http\Requests\InvoiceRequest::class;
    protected $columns = [
    ];
}

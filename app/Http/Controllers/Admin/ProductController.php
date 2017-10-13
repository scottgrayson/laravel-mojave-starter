<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class ProductController extends CrudController
{
    protected $model = \App\Product::class;
    protected $slug = 'products';
    protected $table = 'products';
    protected $singular = 'product';
    protected $plural = 'products';
    protected $formRequest = \App\Http\Requests\ProductRequest::class;
}

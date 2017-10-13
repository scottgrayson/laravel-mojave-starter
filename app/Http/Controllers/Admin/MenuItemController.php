<?php

namespace App\Http\Controllers\Admin;

class MenuItemController extends CrudController
{
    protected $model = \App\MenuItem::class;
    protected $slug = 'menu-items';
    protected $orderable = true;
    protected $singular = 'menu item';
    protected $plural = 'menu items';
    protected $formRequest = \App\Http\Requests\MenuItemRequest::class;
}

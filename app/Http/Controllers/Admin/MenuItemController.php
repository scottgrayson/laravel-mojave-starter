<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class MenuItemController extends CrudController
{
    protected $model = \App\MenuItem::class;
    protected $slug = 'menu-items';
    protected $orderable = true;
    protected $singular = 'menu item';
    protected $plural = 'menu items';
    protected $formRequest = \App\Http\Requests\MenuItemRequest::class;

    public function show($id)
    {
        $page = $this->model::findOrFail($id);

        return redirect($page->href);
    }
}

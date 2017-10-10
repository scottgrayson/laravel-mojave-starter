<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MenuItem;
use Illuminate\Http\Request;

class MenuItemOrderController extends Controller
{
    public function index()
    {
        return MenuItem::getTree();
    }

    public function store(Request $request)
    {
        $menuLength = MenuItem::count();

        $request->validate([
            'order' => "required|array|size:$menuLength",
        ]);

        $order = array_flip(request('order'));

        // TODO would be more efficient to do delete than reinsert
        // but is that safe? Would users load a page with 0 menu items

        foreach (MenuItem::all() as $i) {
            if (isset($order[$i->id])) {
                $i->update(['lft' => $order[$i->id]]);
            } else {
                flash('Error while updating menu order.');
                return redirect(route("admin.menu-item-order.index"));
            }
        };

        flash('Menu order updated.');

        return redirect(route("admin.menu-item-order.index"));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Camper;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $campers = Camper::latest()->limit(20)->get();

        return view('admin.dashboard', [
            'campers' => $campers
        ]);
    }
}

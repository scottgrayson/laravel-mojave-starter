<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        if (auth()->check()) {
            return redirect(route('home'));
        }

        return view('welcome');
    }

    public function home()
    {
        return view('home');
    }
}

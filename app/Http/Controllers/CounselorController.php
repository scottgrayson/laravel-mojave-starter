<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounselorController extends Controller
{
    //
    public function myTent()
    {
        return view('counselors.tent');
    }
}

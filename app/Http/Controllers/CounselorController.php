<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounselorController extends Controller
{
    //
    public function myTent()
    {
        $x = auth()->user()->counselor->tent_id;

        $tent = \App\Tent::find($x);

        return view('counselors.tent')
            ->with('counselorTent', $tent);
    }
}

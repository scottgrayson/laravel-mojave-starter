<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounselorController extends Controller
{
    //
    public function myTent()
    {
        if (auth()->user()->counselor) {
            $x = auth()->user()->counselor->tent_id;
        } else {
            return redirect('/')->withError('This is only available for counselors.');
        }

        $tent = \App\Tent::find($x);

        return view('counselors.tent')
            ->with('counselorTent', $tent);
    }
}

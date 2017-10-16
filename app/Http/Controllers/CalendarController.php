<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampDates;

class CalendarController extends Controller
{
    public function index()
    {
        $camp = CampDates::current();

        return view('calendar.index', [
            'camp' => $camp,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampDates;
use App\Reservation;

class CalendarController extends Controller
{
    public function index()
    {
        // Get Events in the FullCalendar format

        $reservations = !auth()->check() ? collect([]) : Reservation::with('camper')
            ->where('user_id', auth()->user()->id)
            ->get()
            ->map(function ($r) {
                return [
                    'title' => $r->camper->name,
                    'allDay' => true,
                    'tent_id' => $r->tent_id,
                    'date' => $r->date,
                ];
            });

        return view('calendar.index', [
            'reservations' => $reservations,
        ]);
    }
}

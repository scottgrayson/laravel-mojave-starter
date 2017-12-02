<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use SEO;
use App\Camp;
use App\Reservation;

class CalendarController extends Controller
{
    public function index()
    {
        // Get Events in the FullCalendar format

        SEO::setTitle('Calendar');
        SEO::setDescription('Calendar');

        $reservations = !auth()->check() ? collect([]) : Reservation::with('camper')
            ->where('user_id', auth()->user()->id)
            ->get()
            ->map(function ($r) {
                return [
                    'camper_id' => $r->camper_id,
                    'tent_id' => $r->tent_id,
                    'date' => $r->date->toDateString(),
                ];
            });

        $openDays = Camp::current()->openDays()
            ->map(function ($d) {
                return $d->toDateString();
            });

        return view('calendar.index', [
            'reservations' => $reservations,
            'tents' => \App\Tent::all(),
            'campers' => auth()->check() ? auth()->user()->campers : collect([]),
            'openDays' => $openDays,
        ]);
    }
}

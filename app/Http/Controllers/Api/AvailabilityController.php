<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Reservation;
use App\CampDates;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $camp = CampDates::current();

        if (!$camp) {
            return [];
        }

        $reservations = Reservation::select(
            \DB::raw("count(*) as campers"),
            "camper_limit as tent_limit",
            "tents.name as tent_name",
            "tents.id as tent_id",
            "date"
        )
        ->join('tents', 'tents.id', '=', 'reservations.tent_id')
        ->where('date', '<=', $camp->camp_end)
        ->where('date', '>=', $camp->camp_start)
        ->groupBy('date', 'tent_id')
        ->get();

        // Merge with all dates available in camp
        // Excluding weekends and july 4th
        $availabilities = [];

        $d = Carbon::parse($camp->camp_start);
        $end = Carbon::parse($camp->camp_end);

        while ($d <= $end) {
            if (!CampDates::isOpen($d)) {
                $d = $d->addDays(1);
                continue;
            }

            foreach (\App\Tent::all() as $t) {
                $reserved = $reservations->where('date', $d->toDateString())
                    ->where('tent_id', $t->id)
                    ->first();

                $availabilities []= [
                    'date' => $d->toDateString(),
                    'tent_id' => $t->id,
                    'tent_name' => $t->name,
                    'tent_limit' => (int) $t->camper_limit,
                    'campers' => $reserved ? (int) $reserved->campers : 0,
                ];
            }

            $d = $d->addDays(1);
        }

        return $availabilities;
    }
}

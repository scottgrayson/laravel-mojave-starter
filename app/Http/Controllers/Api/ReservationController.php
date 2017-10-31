<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Reservation;
use App\Camper;
use App\Tent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            return auth()->user()->reservations()
                ->whereDate('date', '>', Carbon::now()->toDateString())
                ->get();
        } else {
            return [];
        }
    }

    public function tentReservations(Request $request, $tent)
    {
        $result = Reservation::where('tent_id', $tent)->get()
            ->groupBy('camper_id');

        $x = $result->map(function ($item, $key) {
            $camper = Camper::find($key);
            return [
                'id' => $camper->id,
                'name' => $camper->name,
                'dates' => $item->pluck('date'),
                'allergies' => $camper->allergies
            ];
        })->values();

        return $x;
    }
}

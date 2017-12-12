<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $result = DB::table('reservations')->where('tent_id', $tent)
            ->select(DB::raw('DATE(date) as date'), DB::raw('count(*) as reservations'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $x = $result->map(function ($item, $key) use ($tent) {
            foreach($item as $y) {
                $z = Reservation::where('tent_id', $tent)
                    ->where('date', $item->date)
                    ->get();
            }
            $z = $z->map(function ($item) {
                return [
                    'reservation' => $item->pluck('date'),
                    'camper' => Camper::find($item->camper_id),
                ];
            });
            return $z;
        });

        return $x;
    }
}

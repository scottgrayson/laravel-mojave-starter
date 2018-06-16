<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Camper;
use App\Camp;
use App\Tent;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Attendance for tent.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campers = Camper::with('reservations')->where('tent_id', request('tend_id', 1))
            ->whereHas('reservations', function ($query) use ($request) {
                $query->where('tent_id', $request->input('tent_id', 1));
            })
            ->get();

        $tent = Tent::with('reservations')->where('id', request('tent_id', 1))->first();

        $campDays = Camp::current()->openDays();

        if (request('start')) {
            $start = Carbon::parse(request('start'));
        } else {
            $start = $campDays->first();
        }

        if (request('end')) {
            $end = Carbon::parse(request('end'));
        } else {
            $end = $campDays->take(5)->last();
        }


        $dates = $campDays->filter(function ($date) use ($start, $end) {
            return $date >= $start && $date <= $end;
        });

        return view('admin.attendance', [
            'campers' => $campers,
            'dates' => $dates,
            'tent' => $tent,
            'start' => $start,
            'end' => $end,
        ]);
    }
}

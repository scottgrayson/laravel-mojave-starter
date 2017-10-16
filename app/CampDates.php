<?php

namespace App;

use App\Reservation;
use App\CampDates;
use Carbon\Carbon;

class CampDates extends Model
{
    protected $dates = [
        'camp_start',
        'camp_end',
        'registration_start',
        'registration_end',
    ];

    public static function current()
    {
        return static::where('camp_end', '>', Carbon::now()->toDateString())
            ->first();
    }

    /*
     * Arg date string or carbon
     * Returns bool
     * Check if camp is open
     */
    public static function isOpen($arg = null)
    {
        $date = Carbon::parse($arg);

        $camp = static::where('camp_start', '<=', $date->toDateString())
            ->where('camp_end', '>=', $date->toDateString())
            ->first();

        if (!$camp) {
            return false;
        } elseif ($date->isWeekend()) {
            return false;
        } elseif ($date->month == 7 && $date->day == 4) {
            return false;
        }

        return true;
    }

    public static function availabilities()
    {
        $camp = static::current();

        if (!$camp) {
            return [];
        }

        $reservations = Reservation::select(
            \DB::raw("count(*) as campers"),
            "camper_limit as tent_limit",
            "tents.name as tent_name",
            "tent_id",
            "date"
        )
        ->join('tents', 'tents.id', '=', 'reservations.tent_id')
        ->where('date', '<=', $camp->camp_end)
        ->where('date', '>=', $camp->camp_start)
        ->groupBy('camper_limit', 'tents.name', 'date', 'tent_id')
        ->get();

        // Merge with all dates available in camp
        // Excluding weekends and july 4th
        $availabilities = [];

        $d = Carbon::parse($camp->camp_start);
        $end = Carbon::parse($camp->camp_end);

        while ($d <= $end) {
            if (!static::isOpen($d)) {
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

        return collect($availabilities);
    }
}

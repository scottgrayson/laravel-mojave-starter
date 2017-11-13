<?php

namespace App;

use App\Reservation;
use App\Camp;
use Carbon\Carbon;

class Camp extends Model
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

        $camp = static::whereDate('camp_start', '<=', $date->toDateString())
            ->whereDate('camp_end', '>=', $date->toDateString())
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
        ->whereDate('date', '<=', $camp->camp_end->toDateString())
        ->whereDate('date', '>=', $camp->camp_start->toDateString())
        ->groupBy('camper_limit', 'tents.name', 'date', 'tent_id')
        ->get();

        // Merge with all dates available in camp
        // Excluding weekends and july 4th
        $availabilities = [];

        foreach ($camp->openDays() as $d) {
            foreach (\App\Tent::all() as $t) {
                $reserved = $reservations->filter(function ($r) use ($d) {
                    return Carbon::parse($r->date)->isSameDay($d);
                })
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
        }

        return collect($availabilities);
    }

    /*
     * Get All days from start to finish
     */
    public function openDays()
    {
        $days = collect([]);

        $d = Carbon::parse($this->camp_start);
        $end = Carbon::parse($this->camp_end);

        while ($d <= $end) {
            if (!static::isOpen($d)) {
                $d = $d->addDays(1);
                continue;
            }

            $days->push($d->copy());
            $d = $d->addDays(1);
        }

        return $days;
    }

    public function randomCampDay()
    {
        $campLength = $this->camp_start->diffInDays($this->camp_end);

        $randomDay = $this->camp_start->addDays(rand(0, $campLength));

        while (!self::isOpen($randomDay)) {
            $randomDay = $this->camp_start->addDays(rand(0, $campLength));
        }

        return $randomDay;
    }
}

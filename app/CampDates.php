<?php

namespace App;

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
}

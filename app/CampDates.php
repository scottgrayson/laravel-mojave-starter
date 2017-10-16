<?php

namespace App;

use Carbon\Carbon;

class CampDates extends Model
{
    public static function current()
    {
        return static::where('camp_end', '>', Carbon::now()->toDateString())
            ->first();
    }
}

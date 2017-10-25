<?php

namespace App\Http\Controllers\Api;

use App\CampDates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampDateController extends Controller
{
    public function index()
    {
        $start = CampDates::current()->camp_start;
        $end = CampDates::current()->camp_end;
        $weeks = CampDates::current()->weeks();

        return [
            'camp_start' => $start,
            'camp_end' => $end,
            'weeks' => $weeks,
        ];
    }
}

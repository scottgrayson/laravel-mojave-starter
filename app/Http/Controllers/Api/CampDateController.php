<?php

namespace App\Http\Controllers\Api;

use App\Camp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampDateController extends Controller
{
    public function index()
    {
        $start = Camp::current()->camp_start;
        $end = Camp::current()->camp_end;
        $weeks = Camp::current()->weeks();

        return [
            'camp_start' => $start,
            'camp_end' => $end,
            'weeks' => $weeks,
        ];
    }
}

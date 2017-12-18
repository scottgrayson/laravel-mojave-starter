<?php

namespace App\Http\Controllers\Api;

use App\Camp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampDateController extends Controller
{
    public function index()
    {
        $current = Camp::current();
        $start = $current->camp_start;
        $end = $current->camp_end;
        $weeks = $current->weeks();

        return [
            'camp_start' => $start,
            'camp_end' => $end,
            'weeks' => $weeks,
        ];
    }
}

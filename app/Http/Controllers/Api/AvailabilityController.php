<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\CampDates;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return CampDates::availabilities();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\CampDates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampDateController extends Controller
{
    public function index()
    {
        return CampDates::current()->weeks();
    }
}

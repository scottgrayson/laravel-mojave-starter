<?php

namespace App\Http\Controllers\Api;

use App\Tent;
use App\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TentController extends Controller
{
    public function show($id)
    {
        $result = Tent::find($id)->campers;

        return $result;
    }
}

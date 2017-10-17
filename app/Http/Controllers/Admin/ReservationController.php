<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class ReservationController extends CrudController
{
    protected $model = \App\Reservation::class;
    protected $slug = 'reservations';
    protected $formRequest = \App\Http\Requests\ReservationRequest::class;
    protected $columns = [
        'id',
        'user_id',
        'camper_id',
        'tent_id',
        'date',
        'created_at',
    ];
}

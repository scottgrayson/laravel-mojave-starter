<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class CampDatesController extends CrudController
{
    protected $model = \App\CampDates::class;
    protected $slug = 'camp-dates';
    protected $formRequest = \App\Http\Requests\CampDatesRequest::class;
    protected $columns = [
        'id',
        'camp_start',
        'camp_end',
        'registration_start',
        'registration_end',
    ];
}

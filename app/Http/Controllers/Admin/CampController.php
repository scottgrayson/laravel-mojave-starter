<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class CampController extends CrudController
{
    protected $model = \App\Camp::class;
    protected $slug = 'camps';
    protected $formRequest = \App\Http\Requests\CampRequest::class;
    protected $columns = [
        'id',
        'camp_start',
        'camp_end',
        'registration_start',
        'registration_end',
    ];
}

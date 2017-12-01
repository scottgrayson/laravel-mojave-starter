<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class EventController extends CrudController
{
    protected $model = \App\Event::class;
    protected $slug = 'events';
    protected $formRequest = \App\Http\Requests\EventRequest::class;
    protected $columns = [
        'id',
        'event_type_id',
        'date',
    ];
}

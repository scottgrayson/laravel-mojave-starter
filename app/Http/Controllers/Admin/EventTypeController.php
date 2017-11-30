<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class EventTypeController extends CrudController
{
    protected $model = \App\EventType::class;
    protected $slug = 'event-types';
    protected $formRequest = \App\Http\Requests\EventTypeRequest::class;
    protected $columns = [
        'id',
        'name',
        'emoji',
        'link'
    ];
}

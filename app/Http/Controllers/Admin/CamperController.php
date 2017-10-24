<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class CamperController extends CrudController
{
    protected $model = \App\Camper::class;
    protected $slug = 'campers';
    protected $formRequest = \App\Http\Requests\CamperRequest::class;
    protected $columns = [
        'id',
        'user_id',
        'tent_id',
        'name',
    ];

    /*
        TODO show reservations
    public function show($id)
    {
        $camper = $this->model::findOrFail($id);

        return redirect($camper->uri);
    }
     */
}

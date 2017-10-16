<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class TentController extends CrudController
{
    protected $model = \App\Tent::class;
    protected $slug = 'tents';
    protected $formRequest = \App\Http\Requests\TentRequest::class;
    protected $columns = [
    ];

    /*
        TODO campers by tent / day. Can be viewed by counselors

    public function show($id)
    {
        $tent = $this->model::findOrFail($id);

        return redirect($tent->uri);
    }
     */
}

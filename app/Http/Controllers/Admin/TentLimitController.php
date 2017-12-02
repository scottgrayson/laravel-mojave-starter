<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class TentLimitController extends CrudController
{
    protected $model = \App\TentLimit::class;
    protected $slug = 'tent-limits';
    protected $formRequest = \App\Http\Requests\TentLimitRequest::class;
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class CounselorController extends CrudController
{
    protected $model = \App\Counselor::class;
    protected $slug = 'counselors';
    protected $formRequest = \App\Http\Requests\CounselorRequest::class;
    protected $columns = [
        'id',
        'user_id',
        'tent_id',
        'camp_year',
        'head_counselor',
    ];
}

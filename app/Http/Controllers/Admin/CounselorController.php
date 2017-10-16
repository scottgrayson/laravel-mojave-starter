<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class CounselorController extends CrudController
{
    protected $model = \App\Counselor::class;
    protected $slug = 'counselors';
    protected $table = 'counselors';
    protected $singular = 'counselor';
    protected $plural = 'counselors';
    protected $formRequest = \App\Http\Requests\CounselorRequest::class;
}

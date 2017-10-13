<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class FileController extends CrudController
{
    protected $model = \App\File::class;
    protected $slug = 'files';
    protected $table = 'files';
    protected $singular = 'file';
    protected $plural = 'files';
    protected $formRequest = \App\Http\Requests\FileRequest::class;
}

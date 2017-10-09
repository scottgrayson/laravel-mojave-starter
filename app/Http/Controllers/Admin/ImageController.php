<?php

namespace App\Http\Controllers\Admin;

class ImageController extends CrudController
{
    protected $model = \App\Image::class;
    protected $slug = 'images';
    protected $table = 'images';
    protected $singular = 'image';
    protected $plural = 'images';
    protected $formRequest = \App\Http\Requests\ImageRequest::class;
}

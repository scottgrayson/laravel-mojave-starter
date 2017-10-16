<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class ImageController extends CrudController
{
    protected $model = \App\Image::class;
    protected $slug = 'images';
    protected $table = 'images';
    protected $singular = 'image';
    protected $plural = 'images';
    protected $formRequest = \App\Http\Requests\ImageRequest::class;

    public function show($id)
    {
        $img = $this->model::findOrFail($id);

        return redirect($img->file->url);
    }
}

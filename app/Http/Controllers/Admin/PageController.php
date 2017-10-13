<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;

class PageController extends CrudController
{
    protected $model = \App\Page::class;
    protected $slug = 'pages';
    protected $formRequest = \App\Http\Requests\PageRequest::class;

    public function show($id)
    {
        $page = $this->model::findOrFail($id);

        return redirect($page->uri);
    }
}

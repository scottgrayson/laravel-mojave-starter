<?php

namespace App\Http\Controllers\Admin;

class PageController extends CrudController
{
    protected $model = \App\Page::class;
    protected $slug = 'pages';
    protected $formRequest = \App\Http\Requests\PageRequest::class;
}

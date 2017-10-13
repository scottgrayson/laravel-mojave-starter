<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use SEO;

class PageController extends Controller
{
    public function index(Request $request, $uri)
    {
        $page = Page::findByURI($uri);

        if (!$page) {
            abort(404);
        }

        $isAdmin = auth()->check() && auth()->user()->hasRole('admin');

        if (!$page->published && !$isAdmin) {
            abort(404);
        }

        SEO::setTitle($page->meta_title ? $page->meta_title : $page->title);
        SEO::setDescription($page->meta_description ? $page->meta_description : $page->title);

        return view('page', [
            'page' => $page,
        ]);
    }
}

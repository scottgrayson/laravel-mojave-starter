<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request, $uri)
    {
        $page = Page::findBySlug($uri);

        if (!$page) {
            abort(404);
        }

        $isAdmin = auth()->check() && auth()->user()->hasRole('admin');

        if (!$page->published && !$isAdmin) {
            abort(404);
        }

        return view('page', [
            'page' => $page,
        ]);
    }
}

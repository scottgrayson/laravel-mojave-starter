<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index()
    {
        $forms = Storage::disk('local')->files('public/pdfs');

        return view('forms.show')
            ->with('forms', $forms);
    }
}

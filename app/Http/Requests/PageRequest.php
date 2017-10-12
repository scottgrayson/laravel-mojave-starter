<?php

namespace App\Http\Requests;

class PageRequest extends FormRequest
{
    public function rules()
    {
        $id = \Request::get('id');

        return [
            'name' => 'required',
            'title' => 'required',
            'layout' => 'required',
            'uri' => 'required',
            'published' => 'boolean',
            'meta' => 'nullable',
            'content' => 'nullable',
        ];
    }
}

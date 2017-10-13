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
            'uri' => 'required',
            'published' => 'boolean',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_tags' => 'nullable',
            'content' => 'nullable',
        ];
    }
}

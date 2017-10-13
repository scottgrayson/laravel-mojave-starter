<?php

namespace App\Http\Requests;

class PageRequest extends FormRequest
{
    public function rules()
    {
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

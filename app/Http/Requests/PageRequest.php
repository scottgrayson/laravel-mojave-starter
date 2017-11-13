<?php

namespace App\Http\Requests;

class PageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'uri' => 'required|string|max:255',
            'published' => 'boolean',
            'meta_description' => 'nullable|string',
            'meta_tags' => 'nullable',
            'content' => 'nullable',
        ];
    }
}

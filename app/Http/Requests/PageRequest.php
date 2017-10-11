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
            'slug' => 'unique:pages,slug'.($id ? ','.$id : ''),
            'content' => 'nullable',
            'published' => 'boolean',
        ];
    }
}

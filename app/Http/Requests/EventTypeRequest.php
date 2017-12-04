<?php

namespace App\Http\Requests;

class EventTypeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'emoji' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
        ];
    }
}

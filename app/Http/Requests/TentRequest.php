<?php

namespace App\Http\Requests;

class TentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sex' => 'required|string|max:1',
            'grade' => 'required|numeric',
            'camper_limit' => 'required|numeric',
        ];
    }
}

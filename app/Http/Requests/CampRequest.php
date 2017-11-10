<?php

namespace App\Http\Requests;

class CampRequest extends FormRequest
{
    public function rules()
    {
        return [
            'camp_start' => 'required|date',
            'camp_end' => 'required|date',
            'registration_start' => 'nullable|date',
            'registration_end' => 'required|date',
        ];
    }
}

<?php

namespace App\Http\Requests;

class CampDatesRequest extends FormRequest
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

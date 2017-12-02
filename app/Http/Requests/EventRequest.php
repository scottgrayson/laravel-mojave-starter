<?php

namespace App\Http\Requests;

class EventRequest extends FormRequest
{
    public function rules()
    {
        return [
            'event_type_id' => 'required|numeric',
            'date' => 'nullable|date',
        ];
    }
}

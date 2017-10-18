<?php

namespace App\Http\Requests;

class ReservationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'camper_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
            'date' => 'required|date',
        ];
    }
}

<?php

namespace App\Http\Requests;

class TentLimitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'tent_id' => 'required|numeric',
            'date' => 'required|date',
            'camper_limit' => 'required|numeric',
        ];
    }
}

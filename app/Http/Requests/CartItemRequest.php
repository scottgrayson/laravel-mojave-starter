<?php

namespace App\Http\Requests;

class CartItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'camper_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
            'dates' => 'nullable|array',
        ];
    }
}

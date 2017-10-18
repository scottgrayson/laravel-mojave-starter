<?php

namespace App\Http\Requests;

class CartItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product' => 'required|string|max:255',
            'camper_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
            'date' => 'required|date',
        ];
    }
}

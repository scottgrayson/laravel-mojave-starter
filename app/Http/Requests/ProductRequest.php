<?php

namespace App\Http\Requests;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|max:255|required',
            'price' => 'integer|required',
            'description' => 'string|max:255|required',
        ];
    }
}

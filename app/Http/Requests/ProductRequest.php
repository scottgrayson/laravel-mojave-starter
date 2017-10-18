<?php

namespace App\Http\Requests;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|required',
            'price' => 'integer|required',
            'description' => 'string|required',
        ];
    }
}

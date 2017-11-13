<?php

namespace App\Http\Requests;

class RefundRequest extends FormRequest
{
    public function rules()
    {
        return [
            'emails' => 'required|string',
        ];
    }
}

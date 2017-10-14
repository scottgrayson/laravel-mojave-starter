<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class NewsletterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'subject' => 'required',
            'body' => 'nullable',
        ];
    }
}

<?php

namespace App\Http\Requests;

class NewsletterSubscriberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
        ];
    }
}

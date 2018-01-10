<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class NewsletterSubscriberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                // ignore the user being edited
                Rule::unique('newsletter_subscribers')->ignore($this->route('newsletter_subscriber'))
            ]
        ];
    }
}

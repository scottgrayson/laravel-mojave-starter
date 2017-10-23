<?php

namespace App\Http\Requests;

class CounselorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
            'head_counselor' => 'boolean',
            'year' => 'numeric',
        ];
    }
}

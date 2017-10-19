<?php

namespace App\Http\Requests;

class CounselorRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'user_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
        ];
    }

    public function adminEditRules()
    {
        return [
            'user_id' => 'required|numeric',
            'tent_id' => 'required|numeric',
        ];
    }
}

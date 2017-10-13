<?php

namespace App\Http\Requests;

class FileRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'file' => 'required|file|max:10000',
        ];
    }

    public function adminEditRules()
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'required|numeric',
        ];
    }
}

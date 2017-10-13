<?php

namespace App\Http\Requests;

class ImageRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'file' => 'required|image|max:10000',
        ];
    }

    public function adminEditRules()
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'required|numeric',
            'file_id' => 'required|numeric',
        ];
    }
}

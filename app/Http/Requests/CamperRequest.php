<?php

namespace App\Http\Requests;

class CamperRequest extends FormRequest
{
    public function createRules()
    {
        return [
            'name' => 'required|string|max:255',
            'tent_id' => 'required|numeric',
        ];
    }

    public function editRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }
}

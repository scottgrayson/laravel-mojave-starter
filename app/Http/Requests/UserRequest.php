<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{
    public function editRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }

    public function adminCreateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
        ];
    }

    public function adminEditRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }
}

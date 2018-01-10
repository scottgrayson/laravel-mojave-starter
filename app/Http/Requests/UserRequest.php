<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function editRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                // ignore current user
                Rule::unique('users')->ignore(request()->user()->id)
            ]
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
            'email' => [
                'required',
                'email',
                'max:255',
                // ignore the user being edited
                Rule::unique('users')->ignore($this->route('user'))
            ]
        ];
    }
}

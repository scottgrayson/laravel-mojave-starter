<?php

namespace App\Http\Requests;

class MenuItemRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'page_id' => 'nullable|numeric',
            'parent_id' => 'nullable|numeric',
            'target_blank' => 'boolean',
        ];
    }

    public function adminEditRules()
    {
        return [
            'label' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'page_id' => 'nullable|numeric',
            'parent_id' => 'nullable|numeric',
            'target_blank' => 'boolean',
        ];
    }
}

<?php

namespace App\Http\Requests;

class MenuItemRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'name' => 'required',
            'label' => 'required',
            'link' => 'nullable',
            'page_id' => 'nullable|numeric',
            'parent_id' => 'nullable|numeric',
            'target_blank' => 'boolean',
        ];
    }

    public function adminEditRules()
    {
        return [
            'label' => 'required',
            'link' => 'nullable',
            'page_id' => 'nullable|numeric',
            'parent_id' => 'nullable|numeric',
            'target_blank' => 'boolean',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class FormRequest extends BaseRequest
{
    public function authorize()
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (request()->is('*create*') or request()->isMethod('post')) {
            return $this->createAuthorize();
        } else {
            return $this->editAuthorize();
        }
    }

    public function rules()
    {
        if (request()->is('*create*') or request()->isMethod('post')) {
            if ($this->isAdmin()) {
                return $this->adminCreateRules();
            }
            return $this->createRules();
        } else {
            if ($this->isAdmin()) {
                return $this->adminEditRules();
            }
            return $this->editRules();
        }
    }

    public function isAdmin()
    {
        return request()->is('admin*');
    }

    // Override these in controller with policies
    public function createAuthorize()
    {
        return true;
    }

    public function editAuthorize()
    {
        return true;
    }

    // Override these in child with rules
    public function createRules()
    {
        return [];
    }

    public function editRules()
    {
        return [];
    }

    public function adminCreateRules()
    {
        return [];
    }

    public function adminEditRules()
    {
        return [];
    }
}

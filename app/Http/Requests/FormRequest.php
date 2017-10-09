<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class FormRequest extends BaseRequest
{
    public function authorize()
    {
        if (request()->is('*create*') or request()->isMethod('post')) {
            return $this->createAuthorize();
        } else {
            return $this->editAuthorize();
        }
    }

    public function createAuthorize()
    {
        return true;
    }

    public function editAuthorize()
    {
        return true;
    }

    public function rules()
    {
        if (request()->is('*create*') or request()->isMethod('post')) {
            return $this->createRules();
        } else {
            return $this->editRules();
        }
    }

    public function createRules()
    {
        return [];
    }

    public function editRules()
    {
        return [];
    }
}

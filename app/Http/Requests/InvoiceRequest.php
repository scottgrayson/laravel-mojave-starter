<?php

namespace App\Http\Requests;

class InvoiceRequest extends FormRequest
{
    public function adminCreateRules()
    {
        return [
            'user_id' => 'required|numeric',
            'total' => 'required|numeric',
            'reservations' => 'required|array',
            'registration_fee' => 'required|numeric',
        ];
    }

    public function adminEditRules()
    {
        return [
            ''
        ];
    }
}

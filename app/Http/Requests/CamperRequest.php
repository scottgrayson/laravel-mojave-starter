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
            'tent_id' => 'required|numeric',
            'address' => 'required',
            'city' => 'required',
            'township' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'birthdate' => 'required|date',
            'allergies' => 'required',
            'medical_conditions' => 'required',
            'physician_name' => 'required',
            'physician_phone' => 'required',
            'insurance_carrier' => 'required',
            'insurance_policy_number' => 'required',
            'guardian_name' => 'required',
            'guardian_email' => 'required|email',
            'guardian_address' => 'required',
            'guardian_daytime_phone' => 'required',
            'guardian_evening_phone' => 'required',
            'guardian_work_phone' => 'required',
            'guardian_cell_phone' => 'required',
            'guardian_employer_name' => 'required',
            'guardian_employer_title' => 'required',
            'alternate_contact_name' => 'required',
            'alternate_contact_daytime_phone' => 'required',
            'alternate_contact_evening_phone' => 'required',
            'photo_consent' => 'boolean',
        ];
    }
}

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
            'address' => 'nullable',
            'city' => 'nullable',
            'township' => 'nullable',
            'state' => 'nullable',
            'phone' => 'nullable|phone:AUTO,US',
            'birthdate' => 'nullable|date',
            'allergies' => 'nullable',
            'medical_conditions' => 'nullable',
            'physician_name' => 'nullable',
            'physician_phone' => 'nullable|phone:AUTO,US',
            'insurance_carrier' => 'nullable',
            'insurance_policy_number' => 'nullable',
            'guardian_name' => 'nullable',
            'guardian_email' => 'nullable|email',
            'guardian_address' => 'nullable',
            'guardian_daytime_phone' => 'nullable|phone:AUTO,US',
            'guardian_evening_phone' => 'nullable|phone:AUTO,US',
            'guardian_work_phone' => 'nullable|phone:AUTO,US',
            'guardian_cell_phone' => 'nullable|phone:AUTO,US',
            'guardian_employer_name' => 'nullable',
            'guardian_employer_title' => 'nullable',
            'alternate_contact_name' => 'nullable',
            'alternate_contact_daytime_phone' => 'nullable|phone:AUTO,US',
            'alternate_contact_evening_phone' => 'nullable|phone:AUTO,US',
            'photo_consent' => 'boolean',
        ];
    }

    public function adminEditRules()
    {
        return $this->adminCreateRules();
    }

    public function adminCreateRules()
    {
        return array_merge(['user_id' => 'required'], $this->editRules());
    }
}

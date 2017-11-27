<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CamperRequest extends FormRequest
{
    public function createRules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'tent_id' => 'required|numeric',
        ];
    }

    public function editRules()
    {
        $currentStep = request('step') ? request('step') : 1;
        $index = $currentStep - 1;

        if (!isset($this->steps()[$index])) {
            abort(404);
        }

        return $this->steps()[$index];
    }

    public function adminEditRules()
    {
        return $this->adminCreateRules();
    }

    public function adminCreateRules()
    {
        return [
            'user_id' => 'required|numeric',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'tent_id' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'township' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'camper_phone' => 'nullable|phone:AUTO,US',
            'birthdate' => 'nullable|date',
            'shirt_size' => 'required|in:S,M,L,XL',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_email' => 'nullable|email',
            'guardian_address' => 'nullable|string|max:255',
            'guardian_city' => 'nullable|string|max:255',
            'guardian_township' => 'nullable|string|max:255',
            'guardian_state' => 'nullable|string|max:255',
            'guardian_zip' => 'nullable|string|max:255',
            'guardian_home_phone' => 'nullable|phone:AUTO,US',
            'guardian_work_phone' => 'nullable|phone:AUTO,US',
            'guardian_cell_phone' => 'nullable|phone:AUTO,US',
            'guardian_employer_name' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'physician_name' => 'nullable|string|max:255',
            'physician_phone' => 'nullable|phone:AUTO,US',
            'insurance_carrier' => 'nullable|string|max:255',
            'insurance_policy_number' => 'nullable|string|max:255',
            'alternate_contact_name' => 'nullable|string|max:255',
            'alternate_contact_daytime_phone' => 'nullable|phone:AUTO,US',
            'alternate_contact_evening_phone' => 'nullable|phone:AUTO,US',
            'photo_consent' => 'boolean',
            'henna_consent' => 'boolean',
        ];
    }

    public function steps()
    {
        return [
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'tent_id' => 'required|numeric',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'school_name' => 'required|string|max:255',
                'township' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip' => 'required|string|max:255',
                'camper_phone' => 'required|phone:AUTO,US',
                'birthdate' => 'required|date',
                'shirt_size' => 'required|in:S,M,L,XL',
            ], [
                'guardian_name' => 'required|string|max:255',
                'guardian_email' => 'required|email',
                'guardian_address' => 'required|string|max:255',
                'guardian_city' => 'required|string|max:255',
                'guardian_township' => 'required|string|max:255',
                'guardian_state' => 'required|string|max:255',
                'guardian_zip' => 'required|string|max:255',
                'guardian_home_phone' => 'required|phone:AUTO,US',
                'guardian_work_phone' => 'required|phone:AUTO,US',
                'guardian_cell_phone' => 'required|phone:AUTO,US',
                'guardian_employer_name' => 'required|string|max:255',
            ], [
                'physician_name' => 'required|string|max:255',
                'physician_phone' => 'required|phone:AUTO,US',
                'insurance_carrier' => 'required|string|max:255',
                'insurance_policy_number' => 'required|string|max:255',
                'alternate_contact_name' => 'required|string|max:255',
                'alternate_contact_daytime_phone' => 'required|phone:AUTO,US',
                'alternate_contact_evening_phone' => 'required|phone:AUTO,US',
                'allergies' => 'nullable|string',
                'medical_conditions' => 'nullable|string',
            ], [
                'photo_consent' => 'boolean',
                'henna_consent' => 'boolean',
            ],
        ];
    }
}

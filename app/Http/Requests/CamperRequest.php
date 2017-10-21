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
            'name' => 'required|string|max:255',
            'tent_id' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'township' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'phone' => 'nullable|phone:AUTO,US',
            'birthdate' => 'nullable|date',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_email' => 'nullable|email',
            'guardian_address' => 'nullable|string|max:255',
            'guardian_daytime_phone' => 'nullable|phone:AUTO,US',
            'guardian_evening_phone' => 'nullable|phone:AUTO,US',
            'guardian_work_phone' => 'nullable|phone:AUTO,US',
            'guardian_cell_phone' => 'nullable|phone:AUTO,US',
            'guardian_employer_name' => 'nullable|string|max:255',
            'guardian_employer_title' => 'nullable|string|max:255',
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
        ];
    }

    public function steps()
    {
        return [
            [
                'name' => 'required|string|max:255',
                'tent_id' => 'required|numeric',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'township' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'phone' => 'required|phone:AUTO,US',
                'birthdate' => 'required|date',
            ], [
                'guardian_name' => 'required|string|max:255',
                'guardian_email' => 'required|email',
                'guardian_address' => 'required|string|max:255',
                'guardian_daytime_phone' => 'required|phone:AUTO,US',
                'guardian_evening_phone' => 'required|phone:AUTO,US',
                'guardian_work_phone' => 'required|phone:AUTO,US',
                'guardian_cell_phone' => 'required|phone:AUTO,US',
                'guardian_employer_name' => 'required|string|max:255',
                'guardian_employer_title' => 'required|string|max:255',
            ], [
                'allergies' => 'required|string',
                'medical_conditions' => 'required|string',
                'physician_name' => 'required|string|max:255',
                'physician_phone' => 'required|phone:AUTO,US',
                'insurance_carrier' => 'required|string|max:255',
                'insurance_policy_number' => 'required|string|max:255',
                'alternate_contact_name' => 'required|string|max:255',
                'alternate_contact_daytime_phone' => 'required|phone:AUTO,US',
                'alternate_contact_evening_phone' => 'required|phone:AUTO,US',
            ], [
                'photo_consent' => 'boolean',
            ],
        ];
    }
}

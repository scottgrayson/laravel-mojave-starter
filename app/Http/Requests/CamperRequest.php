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
            'address' => 'nullable',
            'city' => 'nullable',
            'township' => 'nullable',
            'state' => 'nullable',
            'phone' => 'nullable|phone:AUTO,US',
            'birthdate' => 'nullable|date',
            'guardian_name' => 'nullable',
            'guardian_email' => 'nullable|email',
            'guardian_address' => 'nullable',
            'guardian_daytime_phone' => 'nullable|phone:AUTO,US',
            'guardian_evening_phone' => 'nullable|phone:AUTO,US',
            'guardian_work_phone' => 'nullable|phone:AUTO,US',
            'guardian_cell_phone' => 'nullable|phone:AUTO,US',
            'guardian_employer_name' => 'nullable',
            'guardian_employer_title' => 'nullable',
            'allergies' => 'nullable',
            'medical_conditions' => 'nullable',
            'physician_name' => 'nullable',
            'physician_phone' => 'nullable|phone:AUTO,US',
            'insurance_carrier' => 'nullable',
            'insurance_policy_number' => 'nullable',
            'alternate_contact_name' => 'nullable',
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
                'address' => 'required',
                'city' => 'required',
                'township' => 'required',
                'state' => 'required',
                'phone' => 'required|phone:AUTO,US',
                'birthdate' => 'required|date',
            ], [
                'guardian_name' => 'required',
                'guardian_email' => 'required|email',
                'guardian_address' => 'required',
                'guardian_daytime_phone' => 'required|phone:AUTO,US',
                'guardian_evening_phone' => 'required|phone:AUTO,US',
                'guardian_work_phone' => 'required|phone:AUTO,US',
                'guardian_cell_phone' => 'required|phone:AUTO,US',
                'guardian_employer_name' => 'required',
                'guardian_employer_title' => 'required',
            ], [
                'allergies' => 'required',
                'medical_conditions' => 'required',
                'physician_name' => 'required',
                'physician_phone' => 'required|phone:AUTO,US',
                'insurance_carrier' => 'required',
                'insurance_policy_number' => 'required',
                'alternate_contact_name' => 'required',
                'alternate_contact_daytime_phone' => 'required|phone:AUTO,US',
                'alternate_contact_evening_phone' => 'required|phone:AUTO,US',
            ], [
                'photo_consent' => 'boolean',
            ],
        ];
    }
}

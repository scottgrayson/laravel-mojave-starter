<?php

namespace App;

class Camper extends Model
{
    protected $dates = [
        'birthdate'
    ];

    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function reservations()
    {
        return $this->hasMany(\App\Reservation::class);
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getRegistrationCompleteAttribute()
    {
        $rules = (new \App\Http\Requests\CamperRequest)->editRules();
        $requiredFields = $rules;
        $requiredValues = array_intersect_key($this->toArray(), $requiredFields);

        return in_array(null, $requiredValues);
    }

    public function getStatusAttribute() {
        if ($this->registration_complete) {
            return 'Registration Incomplete';
        } elseif ($this->reservations->isEmpty()) {
            return 'No Reservations';
        }

        return 'Camp Dates Reserved';
    }
}

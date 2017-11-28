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

    public function getStatusAttribute()
    {
        $rules = (new \App\Http\Requests\CamperRequest)->editRules();
        $requiredFields = $rules;
        $requiredValues = array_intersect_key($this->toArray(), $requiredFields);

        if (in_array(null, $requiredValues)) {
            return 'Registration Incomplete';
        } elseif ($this->reservations->isEmpty()) {
            return 'No Reservations';
        } else {
            return 'Camp Dates Reserved';
        }
    }
}

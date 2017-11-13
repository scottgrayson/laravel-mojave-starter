<?php

namespace App;

class Tent extends Model
{
    public function campers()
    {
        return $this->hasMany(\App\Camper::class);
    }

    public function counselors()
    {
        return $this->hasMany(\App\Counselor::class);
    }
}

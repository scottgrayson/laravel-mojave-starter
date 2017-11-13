<?php

namespace App;

class Tent extends Model
{
    public function counselors()
    {
        return $this->hasMany(\App\Counselor::class);
    }
}

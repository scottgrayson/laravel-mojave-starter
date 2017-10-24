<?php

namespace App;

class Tent extends Model
{
    public function campers()
    {
        return $this->hasMany(\App\Camper::class);
    }
}

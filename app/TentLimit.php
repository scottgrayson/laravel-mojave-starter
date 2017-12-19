<?php

namespace App;

class TentLimit extends Model
{
    protected $dates = [
        'date',
    ];

    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }
}

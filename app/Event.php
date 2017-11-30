<?php

namespace App;

class Event extends Model
{
    protected $with = [
        'eventType'
    ];

    protected $dates = [
        'date',
    ];

    public function eventType()
    {
        return $this->belongsTo(\App\EventType::class);
    }
}

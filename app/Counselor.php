<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Counselor extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function tent()
    {
        return $this->belongsTo(\App\Tent::class);
    }
}

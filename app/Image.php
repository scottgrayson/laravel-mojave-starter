<?php

namespace App;

class Image extends Model
{
    public function file()
    {
        return $this->belongsTo(\App\File::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

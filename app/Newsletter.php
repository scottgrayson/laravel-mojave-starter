<?php

namespace App;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function opens()
    {
        return $this->hasMany(\App\NewsletterOpen::class);
    }

    public function links()
    {
        return $this->hasMany(\App\NewsletterUrl::class);
    }
}

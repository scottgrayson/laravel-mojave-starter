<?php

namespace App;

use Ramsey\Uuid\Uuid;

class NewsletterUrl extends Model
{
    protected $table = 'newsletter_urls';

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Uuid::uuid4()->toString();
        });

        static::saving(function ($model) {
            $original_slug = $model->getOriginal('slug');

            if ($original_slug !== $model->slug) {
                $model->slug = $original_slug;
            }
        });
    }

    public function newsletter()
    {
        return $this->belongsTo(\App\Newsletter::class);
    }

    public function clicks()
    {
        return $this->hasMany(\App\NewsletterClick::class);
    }

    public function getTrackableUrlAttribute()
    {
        return url(config('app.url') . "/newsletters/short/{$this->slug}");
    }
}

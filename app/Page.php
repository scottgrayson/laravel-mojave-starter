<?php

namespace App;

class Page extends Model
{
    public static function findBySlug($slug)
    {
        $model = self::where('slug', $slug)->first();

        if (!$model) {
            throw new ModelNotFoundException;
        }

        return $model;
    }
}

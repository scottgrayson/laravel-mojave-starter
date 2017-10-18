<?php

namespace App;

class Product extends Model
{
    public static function findBySlug($slug)
    {
        $model = self::where('slug', $slug)->first();

        return $model;
    }
}

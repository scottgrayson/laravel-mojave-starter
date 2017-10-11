<?php

namespace App;

class Page extends Model
{
    public static function findByURI($uri)
    {
        $model = self::where('uri', '/'.$uri)->first();

        if (!$model) {
            throw new ModelNotFoundException;
        }

        return $model;
    }

    public function getHtmlAttribute()
    {
        $PD = new \Parsedown();
        return $PD->text($this->content);
    }
}

<?php

namespace App;

class Page extends Model
{
    public static function findByURI($uri)
    {
        $model = self::where('uri', '/'.$uri)->first();

        return $model;
    }

    public function getHtmlAttribute()
    {
        $PD = new \Parsedown();
        return $PD->text($this->content);
    }

    public function getPreviewUrlAttribute()
    {
        return $this->uri;
    }

    public function getLayoutAttribute()
    {
        return property_exists($this, 'layout') && $this->layout ? $this->layout : 'app';
    }
}

<?php

namespace App;

class File extends Model
{
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /*
     * create new \App\File from a file already on s3
     * optionally provide a name instead name from s3
     */
    public static function createFromStoragePath($filepath, $name = null) 
    {
        return static::create(
            [
            'name' => $name ?: pathinfo($filepath)['basename'],
            'mimetype' => \Storage::getMimetype($filepath),
            'size' => \Storage::getSize($filepath),
            'bucket' => config('filesystems.disks.s3.bucket'),
            'path' => $filepath,
            'user_id' => auth()->check() ? auth()->user()->id : null,
            ]
        );
    }

    public function getIsImageAttribute()
    {
        return strpos($this->mimetype, 'image') !== false;
    }

    public function getUrlAttribute()
    {
        if (config('filesystems.driver') === 's3') {
            return \Storage::temporaryUrl(
                $this->path,
                \Carbon\Carbon::now()->addMinutes(5)
            );
        } else {
            return \Storage::url($this->path);
        }
    }
}

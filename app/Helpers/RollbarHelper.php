<?php

namespace App\Helpers;

class RollbarHelper
{
    public static function get_rollbar_person()
    {
        if (Auth::user()) {
            return [
                'id'       => strval(Auth::user()->id),
                'username' => strval(Auth::user()->name),
                'email'    => strval(Auth::user()->email),
            ];
        } else {
            return [];
        }
    }
}

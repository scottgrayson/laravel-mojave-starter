<?php

// This file is loaded with HelperServiceProvider
//
if (! function_exists('get_rollbar_person')) {
    function get_rollbar_person()
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

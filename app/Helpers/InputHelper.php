<?php

namespace App\Helpers;

class InputHelper
{
    public static function generate($arg)
    {
        return Form::text('name');
    }
}

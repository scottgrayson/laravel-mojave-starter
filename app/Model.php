<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $guarded = ['id'];

    // readable identifier. used for results or selects
    public static function label()
    {
        return 'name';
    }

    public function getLabelAttribute()
    {
        $labelColumn = static::label();
        return property_exists($this, 'label') ? $this->label : $this->$labelColumn;
    }
}

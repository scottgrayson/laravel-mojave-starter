<?php

namespace App;

use Gloudemans\Shoppingcart\Contracts\Buyable;

class Product extends Model implements Buyable
{
    public static function findBySlug($slug)
    {
        $model = self::where('slug', $slug)->first();

        return $model;
    }

    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    public function getBuyableDescription($options = null)
    {
        return $this->description;
    }

    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }
}

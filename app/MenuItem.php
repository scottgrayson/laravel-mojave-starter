<?php

namespace App;

use Cache;

class MenuItem extends Model
{
    protected $with = [
        'page',
        'children',
    ];

    public static function boot()
    {
        static::saving(function ($menuItem) {
            $menuNames = static::whereHas('children')->pluck('name');
            foreach ($menuNames as $name) {
                Cache::forget('menu.' . $name);
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public static function childrenOf($name)
    {
        return Cache::rememberForever('menu.' . $name, function () use ($name) {
            $menu = static::with('children')->where('name', $name)->first();

            return $menu ? $menu->children : collect([]);
        });
    }

    /**
     * Get all menu items, in a hierarchical collection.
     * Only supports 2 levels of indentation.
     */
    public static function getTree()
    {
        $menu = self::orderBy('order')->get();

        if ($menu->count()) {
            foreach ($menu as $k => $menu_item) {
                $menu_item->children = collect([]);

                foreach ($menu as $i => $menu_subitem) {
                    if ($menu_subitem->parent_id == $menu_item->id) {
                        $menu_item->children->push($menu_subitem);

                        // remove the subitem for the first level
                        $menu = $menu->reject(function ($item) use ($menu_subitem) {
                            return $item->id == $menu_subitem->id;
                        });
                    }
                }
            }
        }

        return $menu;
    }

    public function getHrefAttribute()
    {
        if ($this->page_id) {
            return $this->page->uri;
        } elseif (!$this->link) {
            return '#';
        }

        return $this->link;
    }
}

<?php

namespace App;

class MenuItem extends Model
{
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
        $menu = static::where('name', $name)->first();

        return $menu ? $menu->children : collect([]);
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
        if ($this->page) {
            return $this->page->uri;
        } else if (!$this->link) {
            return '#';
        }

        return $this->link;
    }
}

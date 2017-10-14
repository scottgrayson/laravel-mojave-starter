<?php

use App\MenuItem;
use App\Page;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('menu_items')->truncate();

        foreach ($this->menus() as $menu) {
            $this->createMenuItem($menu);
        }
    }

    protected function createMenuItem($i, $parent_id = null)
    {
        $menuItem = MenuItem::create([
            'name' => strtolower($i['name']),
            'label' => isset($i['label']) ? $i['label'] : title_case($i['name']),
            'link' => isset($i['link']) ? $i['link'] : '/'.str_slug($i['name']),
            'target_blank' => isset($i['target_blank']) ? $i['target_blank'] : 0,
            'parent_id' => $parent_id,
            'page_id' => isset($i['page_id']) ? $i['page_id'] : null,
        ]);

        if (isset($i['children']) && count($i['children'])) {
            foreach ($i['children'] as $link) {
                $this->createMenuItem($link, $menuItem->id);
            }
        }
    }

    protected function pageItem($name)
    {
        $page = Page::where('name', $name)->first();

        return [
            'page_id' => $page->id,
            'name' => $page->name,
        ];
    }

    protected function menus()
    {
        return [
            [
                'name' => 'admin top',
                'children' => [
                    [
                        'name' => 'view site',
                        'link' => '/',
                    ],
                    [ 'name' => 'logout' ],
                ],
            ],
            [
                'name' => 'admin sidebar',
                'children' => [
                    [
                        'name' => 'users',
                        'link' => '/admin/users',
                    ],
                    [
                        'name' => 'pages',
                        'link' => '/admin/pages',
                    ],
                    [
                        'name' => 'menu items',
                        'link' => '/admin/menu-items',
                    ],
                    [
                        'name' => 'images',
                        'link' => '/admin/images',
                    ],
                    [
                        'name' => 'files',
                        'link' => '/admin/files',
                    ],
                    [
                        'name' => 'newsletters',
                        'link' => '/admin/newsletters',
                    ],
                    [
                        'name' => 'newsletter subscribers',
                        'link' => '/admin/newsletter-subscribers',
                    ],
                ],
            ],
            [
                'name' => 'admin collapsed',
                'children' => [
                    [
                        'name' => 'users',
                        'link' => '/admin/users',
                    ],
                    [
                        'name' => 'pages',
                        'link' => '/admin/pages',
                    ],
                    [
                        'name' => 'menu items',
                        'link' => '/admin/menu-items',
                    ],
                    [
                        'name' => 'images',
                        'link' => '/admin/images',
                    ],
                    [
                        'name' => 'files',
                        'link' => '/admin/files',
                    ],
                    [
                        'name' => 'newsletters',
                        'link' => '/admin/newsletters',
                    ],
                    [
                        'name' => 'newsletter subscribers',
                        'link' => '/admin/newsletter-subscribers',
                    ],
                    [
                        'name' => 'view site',
                        'link' => '/',
                    ],
                    [ 'name' => 'logout' ],
                ],
            ],
            [
                'name' => 'nav right guest',
                'children' => [
                    [ 'name' => 'register' ],
                    [
                        'name' => 'login button',
                        'link' => '/login',
                    ],
                ],
            ],
            [
                'name' => 'nav right user',
                'children' => [
                    [ 'name' => 'notifications dropdown' ],
                    [
                        'name' => 'user dropdown',
                        'children' => [
                            [ 'name' => 'settings' ],
                            [ 'name' => 'campers' ],
                            [ 'name' => 'logout' ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nav left',
                'children' => [
                    [
                        'name' => 'home',
                        'link' => '/',
                    ],
                    [
                        'name' => 'about',
                        'children' => [
                            [ 'name' => 'general information' ],
                            [ 'name' => 'work parties' ],
                            [ 'name' => 'rules and regulations' ],
                            [ 'name' => 'board of directors' ],
                            [ 'name' => 'photos' ],
                        ],
                    ],
                    [
                        'name' => 'activities',
                        'children' => [
                            [ 'name' => 'your tent' ],
                            [ 'name' => 'wood shop' ],
                            [ 'name' => 'art barn' ],
                            [ 'name' => 'clay barn' ],
                            [ 'name' => 'museum' ],
                            [ 'name' => 'theatre' ],
                            [ 'name' => 'creek' ],
                            [ 'name' => 'games and contests' ],
                            [ 'name' => 'events' ],
                        ],
                    ],
                    [ 'name' => 'enroll' ],
                    [ 'name' => 'calendar' ],
                    $this->pageItem('contact'),
                ],
            ],
            [
                'name' => 'nav collapsed guest',
                'children' => [
                    [
                        'name' => 'home',
                        'link' => '/',
                    ],
                    [ 'name' => 'about' ],
                    [ 'name' => 'activities' ],
                    [ 'name' => 'enroll' ],
                    [ 'name' => 'calendar' ],
                    $this->pageItem('contact'),
                ],
            ],
            [
                'name' => 'nav collapsed user',
                'children' => [
                    [
                        'name' => 'home',
                        'link' => '/',
                    ],
                    [ 'name' => 'about' ],
                    [ 'name' => 'activities' ],
                    [ 'name' => 'enroll' ],
                    [ 'name' => 'calendar' ],
                    $this->pageItem('contact'),
                    [ 'name' => 'my account' ],
                    [ 'name' => 'notifications' ],
                    [ 'name' => 'logout' ],
                ],
            ],
            [
                'name' => 'footer',
                'children' => [
                    $this->pageItem('about'),
                    $this->pageItem('contact'),
                    [
                        'name' => 'newsletter',
                        'link' => '/newsletter-subscription',
                    ],
                ],
            ],
        ];
    }
}

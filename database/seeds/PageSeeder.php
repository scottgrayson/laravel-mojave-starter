<?php

use App\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Page::count()) {
            foreach ($this->pages() as $page) {
                $this->createPage($page);
            }
        }
    }

    protected function createPage($i)
    {
        $page = factory(Page::class)->create([
            'name' => strtolower($i['name']),
            'title' => isset($i['title']) ? $i['title'] : title_case($i['name']),
            'uri' => isset($i['uri']) ? $i['uri'] : '/'.str_slug($i['name']),
            'content' => isset($i['content']) ? $i['content'] : $i['name'],
            'published' => 1,
        ]);
    }

    protected function pages()
    {
        return [
            [
                'name' => 'home',
                'uri' => '/',
            ],
            [ 'name' => 'employment' ],
            [ 'name' => 'thank-you' ],
            [ 'name' => 'about' ],
            [ 'name' => 'contact' ],
            [ 'name' => 'work parties' ],
            [ 'name' => 'rules and regulations' ],
            [ 'name' => 'board of directors' ],
            [ 'name' => 'photo gallery' ],
            [ 'name' => 'your tent' ],
            [ 'name' => 'wood shop' ],
            [ 'name' => 'art barn' ],
            [ 'name' => 'clay barn' ],
            [ 'name' => 'museum' ],
            [ 'name' => 'theatre' ],
            [ 'name' => 'creek' ],
            [ 'name' => 'games and contests' ],
            [ 'name' => 'special events' ],
            [ 'name' => 'registration' ],
            [ 'name' => 'my account' ],
            [ 'name' => 'tuition information' ],
            [ 'name' => 'special areas' ],
            [ 'name' => 'history' ],
            [ 'name' => 'activities' ],

            // For PayPal
            [ 'name' => 'privacy' ],
            [ 'name' => 'terms' ],
        ];
    }
}

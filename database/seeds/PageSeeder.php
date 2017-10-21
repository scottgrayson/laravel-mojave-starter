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
        \DB::statement('truncate pages cascade');

        foreach ($this->pages() as $page) {
            $this->createPage($page);
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
            [ 'name' => 'about' ],
            [ 'name' => 'contact' ],
            [ 'name' => 'general information' ],
            [ 'name' => 'work parties' ],
            [ 'name' => 'rules and regulations' ],
            [ 'name' => 'board of directors' ],
            [ 'name' => 'photos' ],
            [ 'name' => 'activities' ],
            [ 'name' => 'your tent' ],
            [ 'name' => 'wood shop' ],
            [ 'name' => 'art barn' ],
            [ 'name' => 'clay barn' ],
            [ 'name' => 'museum' ],
            [ 'name' => 'theatre' ],
            [ 'name' => 'creek' ],
            [ 'name' => 'games and contests' ],
            [ 'name' => 'events' ],
            [ 'name' => 'enroll' ],
            [ 'name' => 'calendar' ],
            [ 'name' => 'my account' ],
            [ 'name' => 'newsletter' ],
        ];
    }
}

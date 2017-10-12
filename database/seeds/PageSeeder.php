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
        \DB::table('pages')->truncate();

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
        ];
    }
}

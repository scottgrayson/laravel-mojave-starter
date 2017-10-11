<?php

namespace Tests\Feature\Pages;

use App\Page;
use App\User;
use Tests\TestCase;

class PageTest extends TestCase
{
    public function testPublishedPage()
    {
        $page = factory(Page::class)->create([
            'published' => 1,
            'content' => 'hello',
        ]);

        $this->get($page->slug)
            ->assertStatus(200)
            ->see('hello');
    }

    public function testUnpublishedPage()
    {
        $page = factory(Page::class)->create([
            'published' => 0,
            'content' => 'hello',
        ]);

        $this->get($page->slug)
            ->assertStatus(404);

        $this->createAdminRole();
        $admin = factory(User::class)->create();
        $admin->assignrole('admin');

        $this->be($admin);

        $this->get($page->slug)
            ->assertStatus(200)
            ->see('hello');
    }
}

<?php

namespace Tests\Feature\Middleware;

use App\User;
use Tests\TestCase;

class BlockNonAdminTest extends TestCase
{
    public function testBlockingNonAdmins()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->get(route('admin.users.create'))
            ->assertRedirect(route('home'));
    }
}

<?php

namespace Tests\Feature\Users;

use App\User;
use App\Notifications\InviteUser;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InviteUserTest extends TestCase
{
    public function testCreatingUser()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\RoleMiddleware::class
        ]);

        $user = factory(User::class)->make()->only([
            'email',
            'name',
        ]);

        $this->get(route('admin.users.create'))
            ->assertStatus(200);

        Notification::fake();

        $response = $this->post(route('admin.users.store', $user));
        $response->assertRedirect(route('admin.users.edit', 1));

        // assert user created
        $u = User::where('name', $user['name'])->first();
        $this->assertNotNull($u);
        $this->assertNotNull($u->password);

        Notification::assertSentTo($u,
            InviteUser::class,
            function($notification) use ($u) {
                $res = $this->post(route('password.request'), [
                    'token' => $notification->token,
                    'email' => $u->email,
                    'password' => 'secret',
                    'password_confirmation' => 'secret',
                ]);

                $res->assertRedirect(route('home'));
                return true;
            });
    }
}

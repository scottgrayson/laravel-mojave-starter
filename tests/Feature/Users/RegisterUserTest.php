<?php

namespace Tests\Feature\Users;

use App\User;
use App\NewsletterSubscriber;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistersUserTest extends TestCase
{
    public function testCreatingUser()
    {
        $res = $this->post(route('register'), [
            'email' => 'email@email.dev',
            'name' => 'new',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $res->assertStatus(302);

        $u = User::where('name', 'new')->first();
        $this->assertNotNull($u);
        $this->assertNotNull($u->password);

        $newsletterSubscriber = NewsletterSubscriber::where('email', 'email@email.dev')->first();

        $this->assertNotNull($newsletterSubscriber);
    }
}

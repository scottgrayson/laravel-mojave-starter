<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use App\NewsletterSubscriber;

class SubTest extends TestCase
{
    public function testSubscribingFromNewsletter()
    {
        $response = $this->post(route('newsletter-subscriber.store'), ['email' => 'newsletter@test.com']);

        $response->assertStatus(302);

        $found = NewsletterSubscriber::where('email', 'newsletter@test.com')
            ->first();

        $this->assertTrue((bool) $found);
    }
}

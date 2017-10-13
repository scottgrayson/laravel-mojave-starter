<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use App\NewsletterSubscriber;

class UnsubTest extends TestCase
{

    public function testUnsubscribingFromNewsletter()
    {
        $subscriber = NewsletterSubscriber::create([
            'email' => 'newsletter@test.com'
        ]);

        $this->delete(route('newsletter-subscriber.destroy'), [
            'email' => $subscriber->email,
        ]);

        $empty = NewsletterSubscriber::where('email', 'newsletter@test.com')
            ->first();

        $this->assertFalse((bool) $empty);
    }
}

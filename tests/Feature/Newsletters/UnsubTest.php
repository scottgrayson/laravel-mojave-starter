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

        $response = $this->delete(route('newsletter.destroy'), [
            'email' => $subscriber->email,
        ]);

        //$this->feedback($response);

        $empty = NewsletterSubscriber::where('email', 'newsletter@test.com')
            ->first();

        $this->assertFalse((bool) $empty);
    }
}

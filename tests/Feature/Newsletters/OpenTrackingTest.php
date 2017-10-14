<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterOpen;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OpenTrackingTest extends TestCase
{
    use WithoutMiddleware;

    public function testTrackingOpens()
    {
        $newsletter = factory(Newsletter::class)->create();

        $this->assertEquals(0, NewsletterOpen::count());

        $response = $this->call('GET', "/newsletters/open/{$newsletter->id}");

        $this->assertEquals('image/png', $response->headers->get('content-type'));

        $this->assertEquals(1, NewsletterOpen::count());
    }
}

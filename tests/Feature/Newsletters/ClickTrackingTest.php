<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterClick;
use App\NewsletterUrl;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ClickTrackingTest extends TestCase
{
    use WithoutMiddleware;

    public function testTrackingLinks()
    {
        $newsletter = Newsletter::create();

        $trackable = NewsletterUrl::create([
            'target' => 'http://google.com',
            'newsletter_id' => $newsletter->id
        ]);

        $res = $this->get($trackable->trackableUrl)
            ->assertStatus(302)
            ->assertRedirect($trackable->target);

        $found = NewsletterClick::where('newsletter_id', $newsletter->id)
            ->where('newsletter_url_id', $trackable->id)
            ->count();

        $this->assertTrue($found > 0);
    }
}

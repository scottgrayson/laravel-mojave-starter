<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterSubscriber;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SendNewsletterText extends TestCase
{
    use WithoutMiddleware;

    public function testSendingNewsletter()
    {
        Mail::fake();

        $subscriber = NewsletterSubscriber::create([
            'email' => 'newsletter@test.com'
        ]);

        $newsletter = Newsletter::create([
            'title' => 'Newsletter 1',
            'body' => 'Here is the content',
        ]);

        $this->get("/admin/newsletter/{$newsletter->id}/send")
            ->assertResponseStatus(302);

        Mail::assertQueued(MailNewsletter::class, function($mail) {
            return $mail->hasTo('newsletter@test.com');
        });
    }
}

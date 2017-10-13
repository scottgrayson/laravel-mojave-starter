<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterSubscriber;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PreviewNewsletterText extends TestCase
{
    use WithoutMiddleware;

    public function testPreviewingNewsletter()
    {
        Mail::fake();

        $newsletter = Newsletter::create([
            'title' => 'Newsletter 1',
            'body' => 'Here is the content',
        ]);

        $this->post("/admin/newsletter/{$newsletter->id}/preview", [
            'email' => 'test@email.com'
        ])
            ->assertStatus(302);

        Mail::assertQueued(MailNewsletter::class, function ($mail) {
            return $mail->hasTo('test@email.com');
        });
    }
}

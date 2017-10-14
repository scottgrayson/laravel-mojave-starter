<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterSubscriber;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PreviewNewsletterTest extends TestCase
{
    use WithoutMiddleware;

    public function testPreviewingNewsletter()
    {
        Mail::fake();

        $newsletter = factory(Newsletter::class)->create([
            'subject' => 'Newsletter 1',
            'body' => 'Here is the content',
        ]);

        $this->post(route('admin.newsletter.preview', $newsletter->id), [
            'email' => 'test@email.com'
        ])
            ->assertStatus(302);

        Mail::assertQueued(MailNewsletter::class, function ($mail) {
            return $mail->hasTo('test@email.com');
        });
    }
}

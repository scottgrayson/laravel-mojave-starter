<?php

namespace Tests\Feature\Newsletter;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter as MailNewsletter;
use App\Newsletter;
use App\NewsletterUrl;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateNewsletterTest extends TestCase
{
    use WithoutMiddleware;

    public function testTrackingLinks()
    {
        $newsletter = Newsletter::create([
            'subject' => 'Newsletter 1',
            'body' => '
            Some content
            <a href="https://www.indieonthemove.com/availabilities/bands"></a>
            and other content
            <a href="https://www.facebook.com/indieonthemovellc"></a>
            ansd fdsgkdsfhgsd
            <a href="http://www.indieonthemove.com/newsletters/short/TAhuD"></a> ',
        ]);

        $links = NewsletterUrl::all();
        $this->assertEquals(2, $links->count());

        $links = NewsletterUrl::whereIn('target', [
            "https://www.indieonthemove.com/availabilities/bands",
            "https://www.facebook.com/indieonthemovellc",
        ])->get();

        $newsletter = Newsletter::find($newsletter->id);

        $links->each(function ($l) use ($newsletter) {
            $this->assertTrue(false === strpos($newsletter->body, $l->target));
            $this->assertTrue(0 <= strpos($newsletter->body, $l->trackableUrl));

            $this->get($l->trackableUrl)
                ->assertRedirect($l->target);
        });
    }
}

<?php

namespace App\Jobs;

use App\Newsletter;
use App\NewsletterUrl;
use App\NewsletterSubscriber;
use App\Mail\Newsletter as NewsletterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendNewsletter implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $newsletter;
    protected $data;
    protected $preview;

    public function __construct(Newsletter $newsletter, $preview = false)
    {
        $this->preview = $preview;
        $this->newsletter = $newsletter;

        $this->data['links']['tracker'] = url(config('app.url') . "/newsletters/open/{$newsletter->id}");
    }

    public function handle()
    {
        if ($this->preview) {
            $this->data['subscriberEmail'] = $this->preview;

            Mail::to($this->preview)->queue(new NewsletterMail(
                $this->newsletter,
                $this->data
            ))->onQueue('newsletter');

            return;
        }

        NewsletterSubscriber::each(function ($u) {
            $this->data['subscriberEmail'] = $u->email;

            Mail::to($u->email)->queue(new NewsletterMail(
                $this->newsletter,
                $this->data
            ))->onQueue('newsletter');
        });

        $this->newsletter->update([ 'sent_at' => Carbon::now() ]);
    }
}

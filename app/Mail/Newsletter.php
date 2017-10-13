<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Newsletter as NewsletterModel;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;
    public $data;

    public function __construct(NewsletterModel $newsletter, $data)
    {
        $this->newsletter = $newsletter;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter')
            ->subject($this->newsletter->title)
            ->with('newsletter', $this->newsletter)
            ->with('data', $this->data);
    }
}

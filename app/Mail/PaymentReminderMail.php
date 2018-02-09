<?php

namespace App\Mail;

use App\User;
use App\Camp;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->camp = Camp::current();

        $this->url = route('cart.index');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.payments.reminder')
            ->with('user', $this->user)
            ->with('camp', $this->camp)
            ->with('url', $this->url);
    }
}

<?php

namespace App\Mail;

use App\User;
use App\Camp;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public $camp;

    public $url;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->camp = Camp::current();

        $this->url = route('calendar.index');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.payments.reservation-reminder')
            ->with('camp', $this->camp)
            ->with('url', $this->url)
            ->with('user', $this->user);
    }
}

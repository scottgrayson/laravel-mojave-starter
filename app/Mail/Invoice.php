<?php

namespace App\Mail;

use App\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Camper;
use App\Payment;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $total;

    public $user;

    public $reservations;

    public $payment;

    public $url;

    public function __construct($total = null, User $user, $reservations, Payment $payment)
    {
        $this->total = $total;

        $this->user = $user;

        $this->reservations = $reservations;

        $this->payment = $payment;

        $this->url = route('campers.index');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoice')
            ->with('total', $this->total)
            ->with('user', $this->user)
            ->with('reservations', $this->reservations)
            ->with('url', $this->url);
    }
}

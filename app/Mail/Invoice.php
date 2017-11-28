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

    public $dates;

    public $payment;

    public $url;

    public $regisration;

    public function __construct(User $user, $reservations, Payment $payment, $total = null, Payment $registration = null)
    {
        $this->registration = $registration;

        $this->total = $total;

        $this->user = $user;

        $this->reservations = $reservations;

        $this->payment = $payment;

        $dates = collect();

        foreach ($reservations as $r) {
            $camper = Camper::find($r->pluck('camper_id'));
            $dates->push([
                'dates' => $r->pluck('date'),
                'camper' => $camper->pluck('name'),
            ]);
        }

        $this->dates = $dates;

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
            ->with('dates', $this->dates)
            ->with('registration', $this->registration)
            ->with('url', $this->url);
    }
}

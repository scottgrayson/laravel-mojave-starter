<?php

namespace App\Mail;

use App\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Camper;
use App\Invoice;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->registration = $invoice->registration_fee;

        $this->total = $invoice->total;

        $this->user = $invoice->user;

        $res = json_decode($invoice->reservations);

        $this->reservations = collect($res);

        $this->payment = $invoice->total;

        $dates = collect();

        foreach ($this->reservations as $r) {
            $x = collect($r);
            $camper = Camper::find($x->pluck('camper_id'));
            $dates->push([
                'dates' => $x->pluck('date'),
                'camper' => $camper->pluck('first_name'),
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

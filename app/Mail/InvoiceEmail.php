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

    public $user;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->user = $invoice->user;

        $this->url = route('invoices.show', $invoice);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invoice')
            ->with('invoice', $this->invoice)
            ->with('user', $this->user)
            ->with('url', $this->url);
    }
}

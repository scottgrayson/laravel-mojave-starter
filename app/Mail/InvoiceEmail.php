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
use App\Product;

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

    public $registration;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;

        $this->user = $invoice->user;

        $registration = Product::where('slug', 'registration-fee')->firstOrFail();

        $this->registration = $registration->price;

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
            ->with('registration', $this->registration)
            ->with('invoice', $this->invoice)
            ->with('user', $this->user)
            ->with('url', $this->url);
    }
}

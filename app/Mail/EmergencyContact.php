<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Camper;

class EmergencyContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public $camper;

    public $url;

    public function __construct(User $user, Camper $camper)
    {
        $this->user = $user;

        $this->camper = $camper;

        $this->url = asset('MBDC.medical.pdf'); 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emergency-contact')
            ->with('user', $this->user)
            ->with('camper', $this->camper)
            ->with('url', $this->url)
            ->attach('assets/MBDC.medical.pdf', [
                'as' => 'MedicalForm.pdf',
            ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Counselor;
use App\Tent;

class CamperSchedule extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $counselor;

    public $tent;

    public function __construct(Counselor $counselor, Tent $tent)
    {
        $this->counselor = $counselor;

        $this->tent = $tent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.schedule')
            ->with('counselor', $this->counselor)
            ->with('tent', $this->tent);
    }
}

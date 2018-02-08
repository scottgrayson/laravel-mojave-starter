<?php

namespace App\Jobs;

use App\User;
use App\Camper;
use App\Reservations;

use App\Mail\PaymentReminderMail as Reminder;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PaymentReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $users;

    public function __construct()
    {
        $paymentUsers = User::has('reservations')
            ->doesntHave('payments')
            ->get();
        $this->users = $paymentUsers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->users as $user) {
            Mail::to($user->email)->send(new Reminder($user));
        }
    }
}

<?php

namespace App\Jobs;

use App\User;
use App\Camper;
use App\Reservations;

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
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO: 2 emails, one for users with campers and no reservations
        //one email for users with no campers
        $registered = User::whereHas('campers')->whereDoesntHave('reservations')->get();

        $unregistered = User::whereDoesntHave('campers')->get();
    }
}

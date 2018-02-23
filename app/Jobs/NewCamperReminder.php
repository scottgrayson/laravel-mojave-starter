<?php

namespace App\Jobs;

use App\User;
use App\Mail\NewCamperReminderMail as Reminder;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NewCamperReminder implements ShouldQueue
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
        $users = User::whereHas('campers', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->subHours(24), Carbon::now()]);
        })->whereDoesntHave('reservations');

        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            Mail::to($user->email)->send(new Reminder($user));
        }
    }
}

<?php

namespace App\Jobs;

use App\User;
use App\Mail\ReservationReminderMail as Reminder;

use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReservationReminder implements ShouldQueue
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
            $query->where('created_at', '<=', Carbon::now()->addDays(1));
        })->doesntHave('reservations')->get();

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

<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Camp;

use App\Jobs\NewCamperReminder;
use App\Jobs\ReservationReminder;

use Illuminate\Console\Command;

class ReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current = Camp::current();

        if (Carbon::today()->diffInDays($current->camp_start) === 90) {
            ReservationReminder::dispatch();
        } elseif (Carbon::today()->diffInDays($current->camp_start) === 60) {
            ReservationReminder::dispatch();
        } elseif (Carbon::now()->month === 5 && Carbon::now()->dayOfWeek == Carbon::MONDAY) {
            ReservationReminder::dispatch();
        }

        NewCamperRegistration::dispatch();
    }
}

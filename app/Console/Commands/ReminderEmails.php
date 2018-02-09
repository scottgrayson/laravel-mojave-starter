<?php

namespace App\Console\Commands;

use App\Jobs\PaymentReminder;
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
    protected $signature = 'reminder:send {type}';

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
        if ($this->argument('type') === 'payments') {
            PaymentReminder::dispatch();
        } elseif ($this->argument('type') === 'reservations') {
            ReservationReminder::dispatch();
        }
    }
}

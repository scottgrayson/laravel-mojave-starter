<?php

namespace App\Console\Commands;

use App\Jobs\CounselorReminder;
use Illuminate\Console\Command;

class CounselorSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'counselor:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly schedule reminder';

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
        CounselorReminder::dispatch();
    }
}

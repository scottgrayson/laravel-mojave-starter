<?php

namespace App\Jobs;

use App\Tent;
use App\Counselor;
use App\Mail\CamperSchedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CounselorReminder implements ShouldQueue
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
        $tents = Tent::all();

        foreach ($tents as $tent) {
            $counselors = $tent->counselors()->get();
            foreach ($counselors as $counselor) {
                Mail::to($counselor->user->email)->send(new CamperSchedule());
            }
        }
    }
}

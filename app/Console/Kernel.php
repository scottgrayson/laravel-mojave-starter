<?php

namespace App\Console;

use App\Camp;

use App\Jobs\CounselorReminder;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FetchPageContent::class,
        Commands\GrantAdmin::class,
        Commands\GenerateSitemap::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new CounselorReminder)->sundays()->at('12:00');

        /*if (Camp::current()->camp_start->diffInDays(today()) <= 60) {
            $schedule->job(new ReservationReminder)->sundays()->at('02:00');
            $schedule->job(new PaymentReminder)->sundays()->at('01:00');
        }*/

        $schedule->command('reminder:reservations')->daily()->at('11:00');
        $schedule->command('reminder:payment')->daily()->at('12:00');

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        $schedule->command('sitemap:generate')->daily()->at('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        include base_path('routes/console.php');
    }
}

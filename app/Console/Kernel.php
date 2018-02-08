<?php

namespace App\Console;

use App\Camp;

use App\Jobs\CounselorReminder;
use App\Jobs\PaymentReminder;
use App\Jobs\ReservationReminder;

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
        if (Camp::current()->camp_start->diffInDays(today()) <= 60) {
            $reservationUsers = User::has('campers')
                ->doesntHave('reservations')
                ->first();
            $schedule->job(new ReservationReminder)->sundays()->at('04:00');

            $paymentUsers = User::has('reservations')
                ->doesntHave('payments')
                ->first();
            $schedule->job(new PaymentReminder)->sundays()->at('01:00');
        }
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

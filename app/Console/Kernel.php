<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('fenix:check')->everyFifteenMinutes();
        $schedule->command('parts-we-sold:resolve')->everyMinute(); // Check our sales on fenix
        // $schedule->command('ebay:orders')->everyMinute(); // Check our sales on ebay
        $schedule->command('fenix:add-new-parts')->dailyAt('00:00');
        $schedule->command('fenix:resolve-images')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

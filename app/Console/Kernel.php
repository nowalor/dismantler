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

        $schedule->command('parts-we-sold:resolve')->everyMinute(); // Check our sales on fenix
        // $schedule->command('ebay:orders')->everyMinute(); // Check our sales on ebay
        $schedule->command('fenix:add-new-parts')->dailyAt('00:00');
//        $schedule->command('file-storage:purge')->everyFifteenMinutes();
       $schedule->command('fenix:remove-sold-parts')->everyFifteenMinutes();
/*        $schedule->command('fenix:resolve-images-ebay')->everyTenMinutes();*/
           $schedule->command('fenix:fetch')->dailyAt('19:00'); // Get the parts from fenix
        //$schedule->command('german:parts:seed')->dailyAt('18:59');
          $schedule->command('hood:export')->dailyAt('11:23');
          $schedule->command('fenix:resolve-images')->everyTenMinutes();
        $schedule->command('fenix:get-all-parts')->everyThreeMinutes();
        $schedule->command('fenix-images:find-car-part-id')->everyTenMinutes();
        $schedule->command('fenix:resolve-fields')->everyFiveMinutes();
        $schedule->command('cache:warmup')->dailyAt('04:00'); // Off-peak time

        /*        $schedule->command('autoteile-markt:export')->everyTenMinutes();
                $schedule->command('autoteile-markt:upload-parts')->dailyAt('12:00');*/

         //$schedule->command('egluit:purge-parts')->dailyAt('16:08');
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

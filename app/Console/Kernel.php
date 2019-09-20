<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
<<<<<<< HEAD
        // Execute every other hour
        $schedule->command('garfield-bbs:calculate-active-user')->hourly();
        // Execute once every day at 0:00
        $schedule->command('garfield-bbs:sync-user-actived-at')->dailyAt('00:00');
=======

        // Execute the command of "Active User" data generation once an hour
        $schedule->command('larabbs:calculate-active-user')->hourly();
>>>>>>> L03_5.8
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

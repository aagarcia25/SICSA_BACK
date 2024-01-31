<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('custom:monitorweb')->everyTwoMinutes();
    }

    /**
     * Register the commands for the application.
     */
    public $commands = [
        \App\Console\Commands\MonitorWebcronCommand::class,
    ];
}

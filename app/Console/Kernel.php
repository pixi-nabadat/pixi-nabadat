<?php

namespace App\Console;

use App\Console\Commands\ExpirePointsCommand;
use App\Console\Commands\ExpireReservationCommand;
use App\Console\Commands\FcmScheduleCommand;
use App\Console\Commands\PulsesReminderCommand;
use App\Console\Commands\ReservationReminderCommand;
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
        $schedule->command(ExpireReservationCommand::class)->daily();
        $schedule->command(ExpirePointsCommand::class)->daily();
        $schedule->command(PulsesReminderCommand::class)->daily();
        $schedule->command(ReservationReminderCommand::class)->daily();
        $schedule->command(PointsRemindercommand::class)->daily();
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

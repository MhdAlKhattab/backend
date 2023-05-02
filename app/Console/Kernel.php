<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Str;
use App\Models\Investment;
use Carbon\Carbon;
 
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('app:check-investment')->everyMinute();

        $schedule->call(function () {
            $investments = Investment::where('state', 1)->get();
            foreach($investments as $invest){

                // week 604800 sec
                // month 2628288 sec
                // 6 month  15769728 sec
                // year 31539456 sec
                // https://www.digitalocean.com/community/tutorials/easier-datetime-in-laravel-and-php-with-carbon


                
                // info($invest->created_at->secondsSinceMidnight());
                // info(Carbon::now()->secondsSinceMidnight());
                info($invest->updated_at->diffForHumans(Carbon::now()));
                info(Str::contains($invest->updated_at->diffForHumans(Carbon::now()), 'minute'));
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

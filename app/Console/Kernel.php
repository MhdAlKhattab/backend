<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Investment;
use App\Models\Info;
use Carbon\Carbon;
 
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('app:check-investment')->hourly();

        $schedule->call(function () {
            $investments = Investment::where('state', 1)->get();
            foreach($investments as $invest){

                // week 604 800 sec
                // month 2 628 288 sec
                // 6 month  15 778 463 sec
                // year 31 536 000 sec
                // (For Carbon Time) https://www.digitalocean.com/community/tutorials/easier-datetime-in-laravel-and-php-with-carbon

                $period = $invest->return_period;
                $invest_time = Carbon::parse($invest->last_update);
                $now = Carbon::now();
                $diff = $invest_time->diffInSeconds($now);

                if(($period == 'week' and $diff > 604800) or
                ($period == 'month' and $diff > 2628288) or
                ($period == '6 month' and $diff > 15778463) or
                ($period == 'year' and $diff > 31536000)
                ){
                    $invest->number_returned += 1;
                    $invest->last_update = $now;

                    if($invest->number_returned == $invest->total_returned){
                        $invest->message = 'Process Finished';
                        $invest->state = 3;

                        $info = Info::where('user_id', $invest->user_id)->first();
                        $info->interest_balance += $invest->total_returned * $invest->return_amount;
                        $info->save();
                    }
                    $invest->save();
                }

                // info($invest_time);
                // info($invest_time->subSeconds(50));
                // info($now);
                // info($diff);
            }
            // info($investments);
        })->hourly();
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

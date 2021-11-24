<?php

namespace App\Console;

use App\Console\Commands\test1;
use App\Console\Commands\test2;
use App\ContainerTest\ZyBlog;
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
        // $schedule->command('inspire')->hourly();
        $schedule->command('ZyBlog:Test1 2 --b=3')->appendOutputTo("./zyblog_test1.log");

        $schedule->command(test1::class, ['3', '--b=4'])->appendOutputTo("./zyblog_test1.log");

        $schedule->exec("ls -al")->sendOutputTo('./exec_command1.log');

        $schedule->call(function(){
            echo "callable schedule command";

        })->sendOutputTo('./call_command.log');
        $schedule->call(new ZyBlog())->sendOutputTo('./call_command.log');

        $schedule->call(function(){
            echo "Three Minutes：", date('Y-m-d H:i:s');
        })->everyThreeMinutes();

        $schedule->call(function(){
            echo "Cron Three Minutes：", date('Y-m-d H:i:s');
        })->cron("*/3 * * * *");

        $schedule->call(function(){
            echo "周二 每三分钟 9点到10点 Three Minutes：", date('Y-m-d H:i:s');
        })->tuesdays()->everyThreeMinutes()->between('9:00', '10:00');

        $schedule->command(test2::class)->runInBackground()->withoutOverlapping();

        // A scheduled event name is required to prevent overlapping. Use the 'name' method before 'withoutOverlapping'
        $schedule->call(function(){
            echo "不重复运行，", date('Y-m-d H:i:s');
            sleep(30);
        })->name('NoRepect')->withoutOverlapping();

        $schedule->call(function(){
            echo "function";
        })->before(function(){
            echo "before";
        })->after(function(){
            echo "after";
        });

        $schedule->command(test1::class, ['3', '--b=4'])->onSuccess(function(){
            echo "success";
        })->onFailure(function(){
            echo "failure";
        });

        $schedule->call(function(){
            echo "ping";
        })->pingBefore('http://laravel8/request')->thenPing('http://laravel8/request');

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

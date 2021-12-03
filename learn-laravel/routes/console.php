<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('testconsole', function () {
    $this->line("Hello ZyBlog");
});

Artisan::command('question', function () {
    $food = $this->choice('选择午饭', [
        '面条',
        '盖饭',
        '火锅',
    ]);

    $this->line('你的选择是：'.$food);
});


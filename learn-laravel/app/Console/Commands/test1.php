<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class test1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ZyBlog:Test1 {a=1} {--b=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '硬核测试1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        echo "欢迎进来测试！", PHP_EOL;

        print_r($this->arguments());
        // Array
        // (
        //     [command] => ZyBlog:Test1
        //     [a] => 1
        // )
        print_r($this->options());
        // Array
        // (
        //     [b] => Array
        //         (
        //             [0] => 2
        //         )

        //     [help] =>
        //     [quiet] =>
        //     [verbose] =>
        //     [version] =>
        //     [ansi] =>
        //     [no-ansi] =>
        //     [no-interaction] =>
        //     [env] =>
        // )

        echo $this->argument('a'); // 1
        print_r($this->option('b'));
        // Array
        // (
        //     [0] => 2
        // )

        return 1;
    }
}

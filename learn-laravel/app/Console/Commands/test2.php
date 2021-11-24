<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ZyBlog:Test2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        echo "Command sleep 20's, ", date("Y-m-d H:i:s");
        sleep(20);
        return 0;
    }
}

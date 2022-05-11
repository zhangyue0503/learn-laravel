<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        for ($i = 0; $i < 2000000; $i++) {
            $data[] = [
                'username'   => bin2hex(random_bytes(10)),
                'password'   => bin2hex(random_bytes(20)),
                'salt'       => bin2hex(random_bytes(2)),
                'created_at' => date("Y-m-d H:i:s", random_int(time() - 86400 * 365, time())),
                'updated_at' => random_int(time() - 86400 * 365, time()),
                'status'     => random_int(-1, 4),
                'gender'     => random_int(0, 2),
            ];
            if ($i % 2000 == 0) {
                DB::table('test_user')->insert($data);
                $data = [];
            }
        }
        DB::table('test_user')->insert($data);


        return 1;
    }
}

<?php


namespace App\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CreateCustomLogger
{
    public function __invoke(array $config)
    {
        return new Logger('ZyBlog', [new StreamHandler($config['path'])]);
    }
}

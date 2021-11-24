<?php


namespace App\Logging;


use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new LineFormatter(
                'ZYBLOG [%datetime%] %channel%.%level_name%: %message% %context% %extra%'
            ));
        }

    }
}

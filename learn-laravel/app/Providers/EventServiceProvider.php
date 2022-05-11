<?php

namespace App\Providers;

use App\Events\TestEvent;
use App\Listeners\TestListener;
use App\Listeners\TestSubscriber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        TestEvent::class => [
            TestListener::class
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $subscribe = [
        TestSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        Event::listen(StatementPrepared::class, function ($event) {
//            dump($event);
//            #config: array:15 [
//                "driver" => "mysql"
//                "host" => "127.0.0.1"
//                "port" => "3306"
//                "database" => "laravel"
//                "username" => "root"
//                "password" => ""
//                "unix_socket" => ""
//                "charset" => "utf8mb4"
//                "collation" => "utf8mb4_unicode_ci"
//                "prefix" => ""
//                "prefix_indexes" => true
//                "strict" => true
//                "engine" => null
//                "options" => array:1 [▶]
//                "name" => "mysql3"
//              ]

            if($event->connection->getConfig('name') == 'mysql3'){
                $event->statement->setFetchMode(\PDO::FETCH_ASSOC);
            }
//            $event->statement->setFetchMode(\PDO::FETCH_ASSOC);

        });
    }
}

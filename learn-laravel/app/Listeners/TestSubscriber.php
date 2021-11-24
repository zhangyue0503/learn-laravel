<?php


namespace App\Listeners;


use App\Events\TestEvent;
use App\Events\TestEvent2;
use App\Events\TestEvent3;

class TestSubscriber
{
    public function handleTestEvent1($event){
        echo 'This is TestEvent1', $event->a, "<br/>";
    }

    public function handleTestEvent2($event){
        echo 'This is TestEvent2', "<br/>";
    }

    public function handleTestEvent3($event){
        echo 'This is TestEvent3', "<br/>";
    }

    public function handleTestEventAll($event){
        echo "This is AllTestEvent";
        if(isset($event->a)){
            echo $event->a;
        }
        echo "<br/>";
    }


    public function subscribe($events)
    {
        $events->listen(
            [TestEvent::class, TestEvent2::class, TestEvent3::class,],
            [TestSubscriber::class, 'handleTestEventAll']
        );

        $events->listen(
            TestEvent::class,
            [TestSubscriber::class, 'handleTestEvent1']
        );

        $events->listen(
            TestEvent2::class,
            [TestSubscriber::class, 'handleTestEvent2']
        );

        $events->listen(
            TestEvent3::class,
            [TestSubscriber::class, 'handleTestEvent3']
        );
    }

}

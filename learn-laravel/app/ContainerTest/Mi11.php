<?php


namespace App\ContainerTest;


class Mi11 implements IntelligencePhone
{
    public function openApp($name){
        echo __CLASS__ . '打开' . $name, PHP_EOL;
    }
}

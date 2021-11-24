<?php


namespace App\ContainerTest;


class iPhone12 implements IntelligencePhone
{
    public function openApp($name){
        echo __CLASS__ . '打开' . $name, PHP_EOL;
    }
}

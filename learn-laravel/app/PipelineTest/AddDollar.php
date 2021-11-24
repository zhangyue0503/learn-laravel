<?php


namespace App\PipelineTest;


class AddDollar
{
    public function handle($text, $next){
        return $next("$".$text."$");
    }
}

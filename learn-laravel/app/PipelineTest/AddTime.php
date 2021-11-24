<?php


namespace App\PipelineTest;


class AddTime
{
    public function handle($text, $next){
        $t = $next($text);
        return $t . time();
    }
}

<?php


namespace App\PipelineTest;


class EmailChange
{
    public function handle($text, $next){
        return $next(str_replace("@", "#", $text));
    }
}

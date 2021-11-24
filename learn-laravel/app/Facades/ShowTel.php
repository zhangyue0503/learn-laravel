<?php


namespace App\Facades;


class ShowTel extends \Illuminate\Support\Facades\Facade
{


    protected static function getFacadeAccessor()
    {
        return new ShowTelImplement();
    }
}

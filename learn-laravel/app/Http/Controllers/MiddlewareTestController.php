<?php


namespace App\Http\Controllers;


use App\Http\Middleware\MiddlewareTest;

class MiddlewareTestController extends Controller
{

    public function __construct()
    {
//        $this->middleware(MiddlewareTest::class);
    }

    public function test(){

        $a = request()->a;
        $aa = request()->aa;
        return $a + $aa;
    }

    public function test2(){
        $a = request()->a;
        $aa = request()->aa;
        return $a * $aa;
    }
}

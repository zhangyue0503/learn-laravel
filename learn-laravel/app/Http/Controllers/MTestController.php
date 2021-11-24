<?php


namespace App\Http\Controllers;


use App\Models\MTest;

class MTestController extends Controller
{
    public function show(MTest $mTest){
        dump($mTest);
        dump($mTest->name);
    }
}

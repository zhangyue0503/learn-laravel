<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(){
        new Pheanstalk();
    }

    public function test2(Request $request, $id){
        var_dump($request === \request()); // bool(true)
        return 'test2: ' . $id . ', ' . $request->input('name', '') . ', ' . \request()->input('sex', '');
    }
}

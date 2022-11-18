<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test2Controller extends Controller
{
    //
    public function __invoke()
    {
        echo 'single action controller';
        
    }
}

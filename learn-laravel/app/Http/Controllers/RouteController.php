<?php


namespace App\Http\Controllers;


class RouteController extends Controller
{
    public function test($id){
        return 'test ' . $id;
    }
}

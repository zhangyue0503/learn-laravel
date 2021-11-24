<?php


namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends \App\Http\Controllers\Controller
{
    public function register(){
        return User::create([
            'name' => request()->input('name', ''),
            'password' => Hash::make(request()->input('password', '')),
        ]);
    }

    public function login(){
        dump(request()->getPathInfo());
        $name = request()->input('name', '');
        $password = request()->input('password', '');


        $attempt = Auth::attempt(['name' => $name, 'password' => $password]);
        $user = Auth::user();

        $user->api_token = Str::random(60);
        $user->save();

        dd($user, $attempt, $user->api_token);
    }

    public function info(){

        dd(Auth::user());
    }
}

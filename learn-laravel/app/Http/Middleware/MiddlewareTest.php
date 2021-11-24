<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MiddlewareTest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->a){
            $request->aa = $request->a;
        }

        $response = $next($request);

        $response->setContent($response->content() . ' time:' . time());

        return $response;
    }
}

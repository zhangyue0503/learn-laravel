<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (ErrorException $e){
            Log::channel('custom')->error($e->getMessage());
        })->stop();

        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Exception $e, $request){
            if($request->ajax()){
                return response()->json(['code'=>$e->getCode(), 'msg'=>$e->getMessage()]);
            }else{
                if(!($e instanceof HttpException)){
                    return response()->view('errors.custom', ['msg'=>$e->getMessage()], 500);
                }
            }
        });
    }
}

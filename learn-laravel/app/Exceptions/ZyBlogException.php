<?php


namespace App\Exceptions;


use Illuminate\Support\Facades\Log;

class ZyBlogException extends \Exception
{
    /**
     * 报告异常
     *
     * @return void
     */
    public function report()
    {
        Log::channel('custom')->error($this->getMessage());
    }

    /**
     * 渲染异常为 HTTP 响应
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return "异常错误内容为：" . $this->getMessage();
    }

}

<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * 定义统一例外回应方法
     * 
     * @param mixed $message 错误讯息
     * @param mixed $status HTTP状态码
     * @param mixed|null $code 选填，自定义错误编号
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($message, $status, $code = null)
    {
        $code = $code ?? $status; // $code为null时预设HTTP状态码

        return response()->json(
            [
                'message' => $message,
                'code' => $code,
            ],
            $status
        );
    }
}

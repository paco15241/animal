<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        //dd($exception);
        if ($request->expectsJson()) {
            // 1.
            if ($exception instanceof ModelNotFoundException) {
                return$this->errorResponse(
                    '找不到资源',
                    Response::HTTP_NOT_FOUND
                );
            }
            // 2.
            if ($exception instanceof NotFoundHttpException) {
                return$this->errorResponse(
                    '无法找到此网址',
                    Response::HTTP_NOT_FOUND
                );
            }
            // 3.
            if ($exception instanceof MethodNotAllowedHttpException) {
                return$this->errorResponse(
                    $exception->getMessage(),
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
            // 4. p12-19
            if ($exception instanceof AuthorizationException) {
                return$this->errorResponse(
                    $exception->getMessage(),
                    Response::HTTP_FORBIDDEN
                );
            }

        }

        // 执行父类别render的程式
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // 客户端请求 JSON 格式
        if ($request->expectsJson()) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNAUTHORIZED
            );
        } else {
            // 客户端非请求 JSON 格式转回登入画面
            return redirect()->guest($exception->redirectTo() ?? route('login'));
        }
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        // 开发环境下使用whoops重写异常机制
        if (config('app.debug')) {
            if ($request->ajax()) {
                return $this->renderAjaxExceptionWithWhoops($e);
            } else {
                return $this->renderCommonExceptionWithWhoops($e);
            }
        }

        // 是否是Http请求错误
        if ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        }
        // 404 Not Found
        else if ($e instanceof NotFoundHttpException)
        {
            return view('errors.404');
        }
        // 其他错误
        else {
            return parent::render($request, $e);
        }
    }

    /**
     * Render an common exception using Whoops.
     *
     * @param Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderCommonExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run();
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );

    }

    /**
     * Render an ajax exception using Whoops.
     *
     * @param Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderAjaxExceptionWithWhoops(Exception $e)
    {
        $whoops = new \whoops\Run();
        $whoops->pushHandler(new \whoops\Handler\JsonResponseHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }
}

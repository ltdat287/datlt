<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Routing\Router as Route;

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

        if ($this->isHttpException($e)) {
            $url = ($request->url()) ? ($request->url()) : '';

            if (preg_match("/conf$/", $url)) {
                $messages = '入力画面を経由せずに直接参照されました。';

                return response()->view('errors.system_error', ['errors' => [$messages]], 405);
            }

            if (preg_match("/comp$/", $url)) {
                $messages = '確認画面を経由せずに直接参照されました。';

                return response()->view('errors.system_error', ['errors' => [$messages]], 405);
            }
        }

        return parent::render($request, $e);
    }
}

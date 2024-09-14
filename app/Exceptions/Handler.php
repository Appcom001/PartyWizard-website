<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // Render the exception into an HTTP response
    public function render($request, Throwable $exception)
    {
        // If the exception is of type ModelNotFoundException
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        }

        // If the exception is of type NotFoundHttpException
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }

}

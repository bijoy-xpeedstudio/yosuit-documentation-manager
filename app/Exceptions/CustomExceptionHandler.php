<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
class CustomExceptionHandler extends Exception
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return new JsonResponse(['message' => 'Unauthorized'], 403);
        }

        return parent::render($request, $exception);
    }
}

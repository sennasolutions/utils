<?php

namespace Senna\Utils\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class ShowAuthorizationExceptionInDebugMode extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof AuthorizationException && config('app.debug') == true) {
            return $this->prepareResponse($request, $e);
        }
        
        return parent::render($request, $e);
    }
}

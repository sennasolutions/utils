<?php

namespace Senna\Utils\Livewire\Traits;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Senna\Utils\Exceptions\ShowAuthorizationExceptionInDebugMode;

trait WithCustomAuthExceptionHandler
{
    public function bootWithAuthExceptionHandler() {
        app()->singleton(
            ExceptionHandler::class,
            ShowAuthorizationExceptionInDebugMode::class
        );
    }
}

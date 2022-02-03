<?php

namespace Senna\Utils\Exceptions;

use Exception;

class HookException extends Exception
{
    public static function hookDidNotReturnAValue($name)
    {
        throw new static(sprintf(__('Hook %s did not return a value'), $name));
    }
}


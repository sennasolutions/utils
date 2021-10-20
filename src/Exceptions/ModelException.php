<?php

namespace Senna\Utils\Exceptions;

use Exception;

class ModelException extends Exception
{
    public static function couldNotFindInstance($modelClass, $idOrInstance)
    {
        throw new static(sprintf(__('Could not find, or was invalid instance of %s (%s)'), $modelClass, $idOrInstance));
    }
}


<?php

namespace Senna\Utils;

use Senna\Utils\Exceptions\ModelException;

function ensure_model($idOrInstance, $modelClass) {
    $idOrInstance = is_a($idOrInstance, $modelClass) ? $idOrInstance : $modelClass::find($idOrInstance);

    if (!$idOrInstance) {
        ModelException::couldNotFindInstance($modelClass, $idOrInstance);
    }

    return $idOrInstance;
}
<?php

namespace Senna\Utils\Helpers;

use Senna\Utils\Exceptions\ModelException;

function ensure_model($idOrInstance, $modelClass, $withTrashed = false) {
    $idOrInstance = is_a($idOrInstance, $modelClass) ? $idOrInstance : $modelClass::when($withTrashed, fn($query) => $query->withTrashed())->find($idOrInstance);

    if (!$idOrInstance) {
        ModelException::couldNotFindInstance($modelClass, $idOrInstance);
    }

    return $idOrInstance;
}
<?php

namespace Senna\Utils\Helpers;

use Exception;
use Illuminate\Support\Facades\View;

function get_view_hint_and_path() {
    if (!str($viewPath)->contains('::')) {
        $viewPath = '::' . $viewPath;
    }

    $hints = array_merge(['' => View::getFinder()->getPaths()], View::getFinder()->getHints());
    $hint = str($viewPath)->before('::')->__toString();
    $path = str($viewPath)->after('::')->__toString();

    // Check if the hint exists
    if (!isset($hints[$hint])) {
        throw new Exception("Hint '{$hint}' not found.");
    }

    return ['hint' => $hint, 'path' => $path];
}
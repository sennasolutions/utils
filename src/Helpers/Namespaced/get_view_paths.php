<?php

namespace Senna\Utils;

use Exception;
use Illuminate\Support\Facades\View;

function get_view_paths($viewPath) : array {
    if (!str($viewPath)->contains('::')) {
        $viewPath = '::' . $viewPath;
    }

    // Merge base views and plugin namespaces views
    $hints = array_merge(['' => View::getFinder()->getPaths()], View::getFinder()->getHints());
    $hint = str($viewPath)->before('::')->__toString();
    $path = str($viewPath)->after('::')->__toString();

    // Check if the hint exists
    if (!isset($hints[$hint])) {
        throw new Exception("Hint '{$hint}' not found.");
    }

    $directories = collect($hints[$hint])->map(fn($x) => $x . "/" .  str($path)->replace(".", "/")->__toString());

    return $directories->toArray();
}

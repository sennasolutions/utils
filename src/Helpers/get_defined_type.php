<?php

namespace Senna\Utils\Helpers;

use ReflectionNamedType;
use ReflectionProperty;

function get_defined_type($class, $property) : ?ReflectionNamedType {
    $rp = new ReflectionProperty($class, $property);
    $typeName = $rp->getType();

    return $typeName;
}

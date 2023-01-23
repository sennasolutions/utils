<?php

namespace Senna\Utils\Helpers;

use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;

function get_defined_type($class, $property) : ?ReflectionNamedType {
    try {
        $rp = new ReflectionProperty($class, $property);
        $typeName = $rp->getType();

        return $typeName;
    } catch(ReflectionException $ex) {
        return null;
    }
}

<?php

namespace Senna\Utils;

use ReflectionException;

function get_class_name($item, $short = true) {
    try {
        $reflection = (new \ReflectionClass($item));
        return !$short ? $reflection->getName() : $reflection->getShortName();
    } catch(ReflectionException $ex) {
        return null;
    }
}

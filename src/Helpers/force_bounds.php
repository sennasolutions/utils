<?php

namespace Senna\Utils\Helpers;

function force_bounds(?int $min, ?int $max, int $value) {
    if ($min !== null && $value < $min) {
        return $min;
    }
    if ($max !== null && $value > $max) {
        return $max;
    }
    return $value;
}

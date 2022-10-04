<?php

namespace Senna\Utils\Helpers;

function deep_get(mixed $objectOrArray, string $accessorWithDotNotation, mixed $default = null) : mixed {
    return array_reduce(explode('.', $accessorWithDotNotation), fn($o, $p) => is_array($o) ? $o[$p] : $o->{$p} ?? $default, $objectOrArray) ?? $default;
}
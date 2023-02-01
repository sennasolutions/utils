<?php

use Illuminate\Support\Stringable;

if (Stringable::hasMacro('clean')) return;

Stringable::macro('clean', function () {
    $string = $this->__toString();
    $string = preg_replace('!\s+!', ' ', $string);
    $string = trim($string);

    return str($string);
});
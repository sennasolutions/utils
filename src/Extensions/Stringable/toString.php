<?php

use Illuminate\Support\Stringable;

if (Stringable::hasMacro('toString')) return;

Stringable::macro('toString', function () {
    return $this->__toString();
});
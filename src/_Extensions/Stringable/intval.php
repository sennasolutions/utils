<?php

use Illuminate\Support\Stringable;

if (Stringable::hasMacro('intval')) return;

Stringable::macro('intval', function () {
    return intval($this->__toString());
});
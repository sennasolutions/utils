<?php

use Illuminate\Support\Stringable;

if (Stringable::hasMacro('nl2br')) return;

Stringable::macro('nl2br', function () {
    return nl2br($this->__toString());
});
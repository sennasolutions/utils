<?php

use Illuminate\Support\Stringable;

if (Stringable::hasMacro('br2nl')) return;

Stringable::macro('br2nl', function () {
// With regex
    return preg_replace('/<br\\s*?\/??>/i', PHP_EOL, $this->__toString());
});
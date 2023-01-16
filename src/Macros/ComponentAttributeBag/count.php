<?php

use Illuminate\View\ComponentAttributeBag;

if (!method_exists(ComponentAttributeBag::class, 'macro')) return;
if (ComponentAttributeBag::hasMacro('count')) return;

/**
 * Count the values in the attribute bag.
 */
ComponentAttributeBag::macro('count', function () {
    return count($this->attributes);
});
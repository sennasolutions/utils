<?php

use Illuminate\View\ComponentAttributeBag;

if (!method_exists(ComponentAttributeBag::class, 'macro')) return;
if (ComponentAttributeBag::hasMacro('namespace')) return;

/**
 * Namespacing for attributes
 */
ComponentAttributeBag::macro('namespace', function ($namespace = null) {
    if (!$namespace) {
        return $this->root();
    }
    return $this->whereStartsWith($namespace . "::")->strip($namespace . "::");
});
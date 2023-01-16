<?php

use Illuminate\View\ComponentAttributeBag;

if (!method_exists(ComponentAttributeBag::class, 'macro')) return;
if (ComponentAttributeBag::hasMacro('root')) return;

/**
 * Get the root attributes (without namespace)
 */
ComponentAttributeBag::macro('root', function () {
    return $this->withoutKeysContaining("::");
});
<?php

use Illuminate\View\ComponentAttributeBag;

if (!method_exists(ComponentAttributeBag::class, 'macro')) return;
if (ComponentAttributeBag::hasMacro('withoutKeysContaining')) return;

/**
 * Get attributes without keys containing a string
 */
ComponentAttributeBag::macro('withoutKeysContaining', function ($string) {
    $that = clone $this;

    foreach($that as $key => $value) {
        if (str_contains($key, $string)) {
            unset($that[$key]);
        }
    }

    return $that;
});
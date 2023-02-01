<?php

use Illuminate\View\ComponentAttributeBag;

if (!method_exists(ComponentAttributeBag::class, 'macro')) return;
if (ComponentAttributeBag::hasMacro('strip')) return;

/**
 * Strip a part of a string from the attribute keys
 */
ComponentAttributeBag::macro('strip', function ($tag) {
    $that = clone $this;

    foreach($that as $key => $value) {
        $that[(string) str($key)->replaceFirst($tag, "")] = $value;
        unset($that[$key]);
    }

    return $that;
});
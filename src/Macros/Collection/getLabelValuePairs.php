<?php

use Illuminate\Support\Collection;
use Senna\Utils\LabelValuePair;

if (Collection::hasMacro('getLabelValuePairs')) return;

Collection::macro('getLabelValuePairs', function($label = "name", $value = "id", $translate = true) {
    return $this
            ->map(fn($x) => new LabelValuePair($x->$label, $x->$value, $translate));
});
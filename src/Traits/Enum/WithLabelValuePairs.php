<?php

namespace Senna\Utils\Traits\Enum;

use Illuminate\Support\Collection;
use Senna\Utils\LabelValuePair;

trait WithLabelValuePairs
{
    /**
     * Get the enum in a format suitable for a select field.
     * 
     * @return Collection<TKey, LabelValuePair>
     */
    public static function getLabelValuePairs($translate = true) : Collection {
        return collect(self::cases())
            ->map(fn($case) => new LabelValuePair($case->name, $case->value, $translate));
    }
}

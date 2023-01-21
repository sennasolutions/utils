<?php

namespace Senna\Utils;

class LabelValuePair
{
    public function __construct(public string $label, public mixed $value, bool $translate = true)
    {
        if ($translate) {
            $this->label = __($label);
        }
    }
}

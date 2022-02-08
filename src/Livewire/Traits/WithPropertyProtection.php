<?php

namespace Senna\Utils\Livewire\Traits;

use Exception;

trait WithPropertyProtection
{
    protected function initializeWithPropertyProtection()
    {
        if (!method_exists($this, 'mutable') && !property_exists($this, 'mutable')) {
            throw new Exception("The `\$mutable` array must be present on component '{$this->getName()}'");
        }
    }
    
    public function updatingWithPropertyProtection($key, $value)
    {
        $mutable = $this->getMutableProps();

        // Mix with defined rules
        $mutable = collect($this->getRules())
            ->map(fn($x, $key) => $key)
            ->values()
            ->merge($mutable);

        foreach($mutable as $mutableProp) {
            // Make sure form.*.item works
            if (str_contains($mutableProp, "*")) {
                $mutableProp = str($mutableProp)
                    ->replace('.', '\\.')
                    ->replace('*', '.*');

                if (preg_match("/^$mutableProp$/", $key)) {
                    return;
                }
            } else {
                if ($key === $mutableProp) {
                    return;
                }
            }
        }

        throw new Exception("You cannot change the value of the immutable property '{$key}' on component '{$this->getName()}'. Allow it by setting the `\$mutable` array.");
    }


    protected function getMutableProps()
    {
        if (method_exists($this, 'mutable')) return $this->mutable();
        if (property_exists($this, 'mutable')) return $this->mutable;

        return [];
    }
}

<?php

namespace Senna\Utils\Livewire\Traits;

use Exception;

trait WithPropertyProtection
{
    protected function initializeWithPropertyProtection()
    {
        if (!method_exists($this, 'writable') && !property_exists($this, 'writable')) {
            /**
             * @deprecated mutable property protection is deprecated and will be removed in future versions.
             */
            if (!method_exists($this, 'mutable') && !property_exists($this, 'mutable')) {
                throw new Exception("The `\$writable` array must be present on component '{$this->getName()}'");
            }
        }
    }
    
    public function updatingWithPropertyProtection($key, $value)
    {
        $writable = $this->getWritableProps();

        // Mix with defined rules
        $writable = collect($this->getRules())
            ->map(fn($x, $key) => $key)
            ->values()
            ->merge($writable);

        foreach($writable as $writableProp) {
            // Make sure form.*.item works
            if (str_contains($writableProp, "*")) {
                $writableProp = str($writableProp)
                    ->replace('.', '\\.')
                    ->replace('*', '.*');

                if (preg_match("/^$writableProp$/", $key)) {
                    return;
                }
            } else {
                if ($key === $writableProp) {
                    return;
                }
            }
        }

        throw new Exception("You cannot change the value of the readonly property '{$key}' on component '{$this->getName()}'. Allow it by setting the `\$writable` array.");
    }


    protected function getWritableProps()
    {
        if (method_exists($this, 'writable')) return $this->writable();
        if (property_exists($this, 'writable')) return $this->writable;
        
        /**
         * @deprecated mutable is replaced by writable
         */
        if (method_exists($this, 'mutable')) return $this->mutable();
        if (property_exists($this, 'mutable')) return $this->mutable;

        return [];
    }
}

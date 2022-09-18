<?php

namespace Senna\Utils\Livewire\Traits;

trait WithCallTraits
{
    public function callTraits($method, ...$args) {
        // Get the caller method name (performant)
        // $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];

        $refl = new \ReflectionClass($this);

        // dd($refl->getTraits());
        $output = $args[0] ?? null;

        foreach($refl->getTraits() as $trait) {
            $traitMethod = $method . $trait->getShortName();
            if (method_exists($this, $traitMethod)) {
                $output = $this->$traitMethod(...$args);

                if ($output !== null) {
                    $args[0] = $output;
                }
            }
        }

        return $output;
    }
}

<?php

namespace Senna\Utils\TestHelpers;

use Closure;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;

trait TestLivewireSubcomponents
{
    /**
     * Get the subcomponents of a Livewire test component. Filter by component name.
     * 
     * @param TestableLivewire $parent The testtable livewire parent
     * @param string|null $filter The filter to use
     */
    protected function findLivewireSubcomponentsFromParent(TestableLivewire $parent, ?string $filter = null)
    {
        $renderedChildren = collect($parent->instance()->getRenderedChildren());

        foreach($renderedChildren as $child) {
            $childId = $child['id'];

            // Hacky way to get access to the instances see source of Livewire\Testing\TestableLivewire
            $parent->payload['fingerprint']['id'] = $childId;
            $childInstance = $parent->instance();

            if ($filter && !str_contains($childInstance::class, $filter)) {
                continue;
            }

            $params = [];

            foreach ($childInstance as $key => $value) {
                $params[$key] = $value;
            }

            yield [
                'component' => $childInstance,
                'params' => $params
            ];
        }
    }

    /**
     * Get the first subcomponent of a Livewire test component
     *
     * @param TestableLivewire $parent
     * @param string|null $filter
     */
    protected function findFirstLivewireSubcomponent(TestableLivewire $parent, ?string $filter = null) : array {
        $subcomponents = collect($this->findLivewireSubcomponentsFromParent($parent, $filter));

        return $subcomponents->first();
    }

    /**
     * Initialize the testable livewire from an array of subcomponents
     *
     * @param array $subcomponent What findFirstLivewireSubcomponent returned
     * @param array $params Additional initalization params
     * @return TestableLivewire
     */
    protected function initTestableLivewireSubcomponent(array $subcomponent, $params = []) : TestableLivewire {
        $livewireComponent = $subcomponent['component'];
        $params = $subcomponent['params'];

        // Fix delegate issues
        // Adjust the params a bit
        unset($params['delegate']);

        $params['writable'] = array_merge($livewireComponent->writable ?? [], [
            'delegate'
        ], $params);

        // livewireComponent
        return Livewire::test($livewireComponent::class, $params)
            ->set('delegate', $editor->delegate);
    }

    /**
     * Get the first testable subcomponent from a parent
     *
     * @param TestableLivewire $parent The testtable livewire parent
     * @param string|null $filter Filter for specific subcomponent
     * @param array $params
     * @return TestableLivewire
     */
    protected function getTestableLivewireSubcomponent(TestableLivewire $parent, $params = [], ?string $filter = null) : TestableLivewire {
        return $this->initTestableLivewireSubcomponent(
            $this->findFirstLivewireSubcomponent($parent, $filter), 
            $params
        );
    }

    /**
     * Get the first testable subcomponent from a parent
     *
     * @param TestableLivewire $parent The testtable livewire parent
     * @param string|null $filter Filter for specific subcomponent
     * @param array $params
     * @return TestableLivewire
     */
    protected function getTestableLivewireSubcomponents(TestableLivewire $parent, $params = [], ?string $filter = null) : Collection {
        return collect($this->findLivewireSubcomponentsFromParent($parent, $filter))->map(function($subcomponent) use ($params) {
            return $this->initTestableLivewireSubcomponent($subcomponent, $params);
        });
    }
}

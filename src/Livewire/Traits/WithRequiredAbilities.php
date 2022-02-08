<?php

namespace Senna\Utils\Livewire\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Iterable_;

use function Senna\Utils\Helpers\get_class_name;

trait WithRequiredAbilities
{
    protected function initializeWithRequiredAbilities()
    {
        // Check iff the abilities isset
        if (!isset($this->abilities)) {
            throw new Exception("The `\$abilities` array must be set on component '{$this->getName()}'");
        }
    }

    protected function authorizeAbilities(mixed $resources, string $staticModel) {
        $resources = is_array($resources) ? $resources : [ $resources ];

        foreach($this->abilities as $ability) {
            $this->authorizeAbility($resources, $staticModel, $ability);
        }
    }

    protected function authorizeAbility(mixed $resources, string $staticModel, string $ability) {
        $resources = is_array($resources) ? $resources : [ $resources ];

        foreach($resources as $resource) {
            $type = $resource ? get_class_name($resource) : get_class_name($staticModel);

            $response = Gate::inspect($ability, $resource ?? $staticModel);

            if ($response->denied()) {
                $role = user()->roles->map(fn($x) => $x->slug)->join(',') ?? null;
                $roleText = $role ? "role `{$role}`" : 'user';
                $msg = $response->message();
                $msgText = $msg ? " - {$msg}." : '';
                $resourceId = $resource->id ?? null;

                throw new AuthorizationException("Denied '{$type}.{$ability}' for $roleText $msgText Component: '{$this->getName()}'  Id: $resourceId");
            }
        }
    }
}

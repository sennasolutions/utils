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

    /**
     * Authorize the abilities specified in the $abilities array on the given resources
     *
     * @param mixed $resources
     * @param string|null $staticModel
     * @return void
     */
    protected function authorizeAbilities(mixed $resources, string $staticModel = null) {
        $resources = is_array($resources) ? $resources : [ $resources ];

        foreach($this->abilities as $ability) {
            $this->authorizeAbility($resources, $staticModel, $ability);
        }
    }

    /**
     * Authorize the given ability on the given resources
     *
     * @param mixed $resources
     * @param string|null $staticModel
     * @param string $ability
     * @return void
     */
    protected function authorizeAbility(mixed $resources, string $staticModel = null, string $ability) {
        $resources = is_array($resources) ? $resources : [ $resources ];

        foreach($resources as $resource) {
            if (is_integer($resource)) {
                $resource = $staticModel::find($resource);
            }
            $type = $resource ? get_class_name($resource) : get_class_name($staticModel);

            // $response = Gate::authorize($ability, [user(), $resource ?? $staticModel]);
            $response = Gate::inspect($ability, $resource ?? $staticModel);

            if ($response->denied()) {
                $role = user()?->roles->map(fn($x) => $x->slug)->join(',') ?? null;
                $roleText = $role ? "role `{$role}`" : 'user';
                $msg = $response->message();
                $msgText = $msg ? " - {$msg}." : '';
                $resourceId = $resource->id ?? null;

                throw new AuthorizationException("Denied '{$type}.{$ability}' for $roleText $msgText Component: '{$this->getName()}'  Id: $resourceId");
            }
        }
    }

}

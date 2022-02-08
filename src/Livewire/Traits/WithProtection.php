<?php

namespace Senna\Utils\Livewire\Traits;

/**
 * This trait is used to protect public livewire properties from being changed by the user by default in frontend via Livewire JS calls.
 * See: https://www.reddit.com/r/laravel/comments/q0qrri/livewire_extremely_insecure/
 * 
 * If you want to 'expose' methods and properties you must use the $callable and $mutable properties to do so.
 * By default every property defined in $rules or rules() is considered mutable.
 * 
 * This trait will throw an exception if mutable and callable properties are non-existant on your component;
 * 
 * WithPropertyProtection is used to protect the properties of the component
 * WithMethodProtection is used to protect the methods of the component
 * 
 */
trait WithProtection
{
   // public $mutable = [];
   // public $callable = [];
   // public $abilities = [];
   
   use WithPropertyProtection;
   use WithMethodProtection;
   use WithRequiredAbilities;
}

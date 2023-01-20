<?php

use function Senna\Utils\Helpers\get_private_property;

class ExampleParentClass {
    private $privateProperty = 'parentPrivate';
    protected $protectedProperty = 'parentProtected';

    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }
}

class ExampleClass extends ExampleParentClass {
    private $privateProperty2 = 'private';

    public function getPrivatePropert2y()
    {
        return $this->privateProperty2;
    }
}

it('can access private property', function()
{
    $example = new ExampleClass();

    $test = get_private_property($example, 'privateProperty', ExampleParentClass::class);

    expect($test)->toBe('parentPrivate');

    $test = get_private_property($example, 'privateProperty2');

    expect($test)->toBe('private');

    $test = get_private_property($example, 'protectedProperty');

    expect($test)->toBe('parentProtected');
});

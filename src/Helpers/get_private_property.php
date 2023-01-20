<?php

namespace Senna\Utils\Helpers;

/**
 * Access the private property of an object or it's parent
 *
 * @see https://www.lambda-out-loud.com/posts/accessing-private-properties-php/ method 2
 * 
 * @param mixed $instance
 * @param ?string $property
 * @param ?string $class
 * @return void
 */
function get_private_property(mixed $instance, string $property, ?string $class = null) : mixed
{
    $array = (array) $instance;
    $class = $class ?? get_class($instance);

    foreach($array as $key => $value) {
        $privatePrefix = "\0" . ($class) . "\0";
        $protectedPrefix = "\0*\0";

        if ($key === $property || $key == $privatePrefix . $property || $key == $protectedPrefix . $property) {
            return $value;
        }
    }

    return null;
}
<?php

namespace Senna\Utils\Traits\Cast;

use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

use function Senna\Utils\Helpers\get_defined_type;

trait JsonCast
{
    public static function castUsing(array $arguments)
    {
        $static = self::class;

        return new class($static) implements CastsAttributes
        {
            private $static;

            public function __construct($static)
            {
                $this->static = $static;
            }

            public function get($model, $key, $value, $attributes)
            {
                return $this->static::castFrom((array) json_decode($value));
            }
 
            public function set($model, $key, $value, $attributes)
            {
                return json_encode($value->castTo());
            }
        };
    }

    public static function castFrom(array $arguments) : self
    {
        $options = new self();

        foreach($arguments as $key => $value) {
            $definedType = get_defined_type($options, $key);
            $definedTypeName = $definedType->getName();

            // enum
            if (is_subclass_of($definedTypeName, BackedEnum::class)) {
                if ($definedType->allowsNull() || $definedTypeName::tryFrom($value)) {
                    $options->$key = $definedTypeName::tryFrom($value);
                }
            } else if (!is_object($value)) {
                $options->$key = $value;
            } else {
                if (!$value && $definedType->allowsNull()) {
                    $options->$key = null;
                } else if (method_exists($definedTypeName, 'castFrom')) {
                    $options->$key = $definedTypeName::castFrom((array) $value);
                } else {
                    $options->$key = (array) $value;
                }
            }
        }

        return $options;
    }

    public function castTo() : array
    {
        $array = [];
        // Loop over props
        foreach($this as $key => $value) {
            if (is_object($value)) {
                if (method_exists($value, 'castTo')) {
                    $array[$key] = $value->castTo();
                } else {
                    $array[$key] = (array) $value;
                }
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}

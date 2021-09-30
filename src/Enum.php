<?php

namespace Senna\Utils;

use ReflectionClass;

abstract class Enum {
    private static $constCacheArray = NULL;

    public static function getConstants($name = null) {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        $consts = self::$constCacheArray[$calledClass];

        if ($name && !self::isValidName($name)) return null;

        return $name ? $consts[$name] : $consts;
    }

    public static function isValidName($name, $strict = true) {
        if ($name === null) return false;

        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    public static function list() {
        return array_map(fn($item) => __($item), array_flip(self::getConstants()));
    }

    public static function get($key) {
        return self::list()[$key] ?? null;
    }
}

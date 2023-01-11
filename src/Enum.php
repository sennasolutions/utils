<?php

namespace Senna\Utils;

use ReflectionClass;

abstract class Enum {
    private static $constCacheArray = NULL;

    /**
     * Gets the name/keys as an associative array
     *
     * Name => Key
     *
     * For example:
     *  [
     *      "Trial" => 1
     *      "Subscription" => 2
     *      "Prepaid" => 3
     *      "Workshop" => 4
     *  ]
     *
     * @param string $name Filter by name
     * @return ?array
     */
    public static function getListByName() : ?array {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    /**
     * Gets a key by name
     *
     * @param [type] $name
     * @return void
     */
    public static function getKey($name) {
        return self::isValidName($name) ? self::getListByName()[$name] : null;
    }

    /**
     * Checks if this is a valid name
     *
     * For example:
     *    "Trial" returns true
     *    "RandomString" returns false
     *
     * @param string $name
     * @param boolean $strict
     * @return bool
     */
    public static function isValidName($name, $strict = true) {
        if ($name === null) return false;

        $constants = self::getListByName();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    /**
     * Checks if this is a valid key
     *
     * For example:
     *  1 returns true
     *  0 returns false
     *
     * @param String|Int $value
     * @param boolean $strict
     * @return boolean
     */
    public static function isValidKey($value, $strict = true) {
        $values = array_values(self::getListByName());
        return in_array($value, $values, $strict);
    }

    /**
     * Get the reverse of getListByName()
     *
     * For example:
     *  [
     *      1 => "Trial"
     *      2 => "Subscription"
     *      3 => "Prepaid"
     *      4 => "Workshop"
     *  ]
     *
     * @return ?array
     */
    public static function getList(bool $translate = true) : ?array {
        return array_map(fn($item) => $translate ? __($item) : $item, array_flip(self::getListByName()));
    }

    /**
     * Gets a name by key
     *
     * For example:
     * 1 returns "Trial"
     *
     * @return ?String
     */
    public static function get($key, bool $translate = true) : ?String {
        return self::getList($translate)[$key] ?? null;
    }

    /**
     * Get the reverse of getListByName()
     *
     * For example:
     * [
     *     [ value => 1, label => "Trial" ],
     *     [ value => 2, label => "Subscription" ],
     * ]
     *
     * @return array|null
     */
    public static function getListInLabelValueFormat(): ?array
    {
        return collect(static::getList())->map(function ($item, $key) {
            return [
                'label' => $item,
                'value' => $key,
            ];
        })->values()->toArray();
    }
}

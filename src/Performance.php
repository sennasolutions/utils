<?php

namespace Senna\Utils;

class Performance {
    public static $logs = [];
    public static $colors = ['blue', 'red', 'green', 'purple', 'grey'];

    public static $results = [];

    public static function start($name) {
        if (!static::isActive()) return;

        $int = intval(preg_replace("/[^\d]/", "", md5($name)));

        static::$results[$name] = [
            'start' => microtime(true),
            'end' => null
        ];

        clock()->event($name)->color(static::$colors[$int % count(static::$colors)])->begin();
    }

    public static function end($name) : string {
        if (!static::isActive()) return "";

        static::$results[$name] = [
            'start' => static::$results[$name]['start'],
            'end' => microtime(true)
        ];

        clock()->event($name)->end();

        return static::get($name);
    }

    public static function stop($name)
    {
        return static::end($name);
    }

    public static function get($name)
    {
        $result = static::$results[$name] ?? ['start' => 0, 'end' => 0];

        // Display in milliseconds
        return "$name completed in " . round(($result['end'] - $result['start']) * 1000, 2) . "ms";
    }

    public static function log($name)
    {
        echo "-> " . static::get($name) . PHP_EOL;
    }

    public static function endAndLog($name)
    {
        $result = static::end($name);
        echo "-> $result" . PHP_EOL;
    }

    public static function isActive() {
        return (env('APP_ENV') === "local");
    }
}

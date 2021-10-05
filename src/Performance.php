<?php

namespace Senna\Utils;

class Performance {
    public static $logs = [];
    public static $colors = ['blue', 'red', 'green', 'purple', 'grey'];

    public static function start($name) {
        if (!static::isActive()) return;

        $int = intval(preg_replace("/[^\d]/", "", md5($name)));

        clock()->event($name)->color(static::$colors[$int % count(static::$colors)])->begin();
    }

    public static function end($name) {
        if (!static::isActive()) return;
        clock()->event($name)->end();
    }

    public static function stop($name)
    {
        return static::end($name);
    }

    public static function isActive() {
        return (env('APP_ENV') === "local");
    }
}

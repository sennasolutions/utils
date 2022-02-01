<?php

namespace Senna\Utils;

class Hook
{
    protected static $registerdHooks = [];

    public static function register($name, $callback, $prio = 10)
    {
        if (!isset(static::$registerdHooks[$name])) {
            static::$registerdHooks[$name] = [];
        }

        static::$registerdHooks[$name][] = [
            'callback' => $callback,
            'prio' => $prio
        ];
    }

    public static function run($name, $params = [])
    {
        $params = is_array($params) ? $params : [$params];
        $currentOutput = $params[0] ?? null;

        if (!isset(static::$registerdHooks[$name])) return $currentOutput;

        $hooks = collect(static::$registerdHooks[$name])->sortBy('prio');

        foreach ($hooks as $hook) {
            // Chop off the first parameter
            $params = [$currentOutput, ...array_slice($params, 1)];
            $currentOutput = $hook['callback'](...$params);
        }

        return $currentOutput;
    }

}

<?php

namespace Senna\Utils;

use Closure;
use Senna\Utils\Exceptions\HookException;

class Hook
{
    protected static $registerdHooks = [];

    /**
     * Clear hooks for testing purposes.
     *
     * @return void
     */
    public static function clearHooks() {
        static::$registerdHooks = [];
    }

    /**
     * Registers a hook
     *
     * @param string $name
     * @param Closure $callback
     * @param integer $prio
     * @return void
     */
    public static function register(string $name, Closure $callback, int $prio = 10) : void
    {
        if (!isset(static::$registerdHooks[$name])) {
            static::$registerdHooks[$name] = [];
        }

        static::$registerdHooks[$name][] = [
            'callback' => $callback,
            'prio' => $prio
        ];
    }

    /**
     * Runs a hook.
     *
     * @param string $name
     * @param mixed ...$params
     * @return mixed
     * 
     * @throws HookException
     */
    public static function run(string $name, ...$params) : mixed
    {
        $params = is_array($params) ? $params : [$params];
        $currentOutput = $params[0] ?? null;

        if (!isset(static::$registerdHooks[$name])) return $currentOutput;

        $hooks = collect(static::$registerdHooks[$name])->sortBy('prio');

        foreach ($hooks as $hook) {
            // Chop off the first parameter
            $params = [$currentOutput, ...array_slice($params, 1)];
            $currentOutput = $hook['callback'](...$params);

            if ($currentOutput === null) {
                throw HookException::hookDidNotReturnAValue($name);
            }
        }

        return $currentOutput;
    }

}

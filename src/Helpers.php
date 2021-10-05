<?php

namespace Senna\Utils;

use Illuminate\Support\Str;

class Helpers {
    /**
     * Include helpers from a directory.
     *
     * @param string $directory
     * @return void
     */
    public static function include(string $directory = null, $inGlobalScope = true) {
        $directory = $directory ?? __DIR__ . "/Helpers";
        foreach (scandir($directory) as $helperFile) {
            $path = $directory . "/" . $helperFile;

            if (! is_file($path)) {
                continue;
            }

            $function = Str::before($helperFile, '.php');

            if ($inGlobalScope && function_exists($function)) {
                continue;
            }

            require_once $path;
        }
    }

    
}
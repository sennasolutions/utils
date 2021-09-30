<?php

namespace Senna\Utils;

class Extensions {
    /**
     * Include helpers from a directory.
     *
     * @param string $directory
     * @return void
     */
    public static function include(string $directory = null) {
        $directory = $directory ?? __DIR__ . "/Helpers";
        foreach (scandir($directory) as $extensionFile) {
            $path = $directory . "/" . $extensionFile;

            if (substr($extensionFile, 0, 1) === ".") continue;

            if ( is_dir($path)) {
                static::include($path);
            }

            if (! is_file($path)) {
                continue;
            }

            require_once $path;
        }
    }

    
}
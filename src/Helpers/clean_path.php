<?php

namespace Senna\Utils\Helpers;

/**
 * Clean a path to remove any unnecessary slashes.
 *
 * @param string $path
 *   The path to clean.
 *
 * @return string
 *   The cleaned path.
 */
function clean_path($path) {
    $path = preg_replace('/\/+/', '/', $path);
    $path = trim($path, '/');
    $path = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $path);

    return $path;
}
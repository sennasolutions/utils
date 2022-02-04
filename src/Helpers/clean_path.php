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
function clean_path($path, $allowSpaces = false) {
    if (!$allowSpaces) {
        $path = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $path);
    } else {
        $path = preg_replace('/[^a-zA-Z0-9\s_\-\/]/', '', $path);
    }

    $path = trim($path, '/');
    $path = preg_replace('/\/+/', '/', $path);
    $path = preg_replace('/\s+/', ' ', $path);

    return $path;
}
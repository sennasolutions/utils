<?php

namespace Senna\Utils\Helpers;

use Illuminate\Support\Facades\File;

/**
 * Check if a path contains a filename or a substring of the filename
 *
 * @param [type] $path
 * @param [type] $string
 * @param boolean $use_str_contains
 * @return void
 */
function path_contains_file(string $path, string $search, bool $use_str_contains = true, bool $return_filename = false) {
    foreach (File::allFiles($path) as $file) {
        $relativePath = str_replace($path, '', $file->getPathname());
        if ($use_str_contains) {
            if (str_contains($file->getFilename(), $search)) {
                return $return_filename ? $relativePath : true;
            }
        } else {
            if ($file->getFilename() == $search) {
                return $return_filename ? $relativePath : true;
            }
        }
    }

    return false;
}
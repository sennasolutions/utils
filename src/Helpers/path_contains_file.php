<?php

namespace Senna\Utils\Helpers;

use Illuminate\Support\Facades\File;

function path_contains_file($path, $string, $use_str_contains = true) {
    foreach (File::allFiles($path) as $file) {
        if ($use_str_contains) {
            if (str_contains($file->getFilename(), $string)) {
                return true;
            }
        } else {
            if ($file->getFilename() == $string) {
                return true;
            }
        }
    }

    return false;
}
<?php

namespace Senna\Utils\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;


/**
 * Check if a path contains a filename or a substring of the filename
 *
 * 
 * p,ul[style],ol,li,b,strong,i,em
 * 
 * @param [type] $path
 * @param [type] $string
 * @param boolean $use_str_contains
 * @return void
 */
function filter_html(string $html, $allowed = "p,ul,ol,li,b,strong,i,em") {
    $cachePath = storage_path('framework/cache/htmlpurifier');
    if (!is_dir($cachePath)) {
        mkdir($cachePath, 0775, true);
    }

    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', $allowed);
    $config->set('Cache.SerializerPath', $cachePath);

    $purifier = new HTMLPurifier($config);

    return $purifier->purify($html);
}
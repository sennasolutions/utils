<?php

namespace Senna\Utils\Helpers;

use Illuminate\Support\Facades\File;

function relative_link(string $from, string $to) {
    File::delete($to);

    $relativeFrom = get_relative_path($to, $from);

    return File::link($relativeFrom, $to);
}
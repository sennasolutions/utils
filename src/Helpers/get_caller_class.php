<?php

namespace Senna\Utils\Helpers;

function get_caller_class($distance = 2) {
    $dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $distance + 1);
    return $dbt[$distance]['object'] ?? null;
}
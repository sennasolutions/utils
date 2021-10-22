<?php

namespace Senna\Utils\Helpers;

function get_caller_instance($distance = 2) {
    $dbt=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, $distance + 1);
    return $dbt[$distance]['object'] ?? null;
}
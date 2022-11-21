<?php

namespace Senna\Utils\Helpers;

use Closure;
use Senna\Utils\SnapCache;

function snap(Closure $closure, mixed $key, array $args = []) {
    return app(SnapCache::class)->closure($closure, $key, $args);
}

function snap_clear(mixed $key = null) {
    return app(SnapCache::class)->clear($key);
}

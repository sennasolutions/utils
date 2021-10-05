<?php

namespace Senna\Utils;

function snap($closure, $key, $args = []) {
    return app(SnapCache::class)->closure($closure, $key, $args);
}

function snap_clear($key) {
    return app(SnapCache::class)->clear($key);
}

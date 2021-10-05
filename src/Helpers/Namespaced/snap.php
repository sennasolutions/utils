<?php

namespace Senna\Utils;

function snap($closure, $args = []) {
    return app(SnapCache::class)->closure($closure, $args);
}
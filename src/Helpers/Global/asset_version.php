<?php

function asset_version($path) {
    $filepath = public_path($path);

    return asset($path . "?v=" . filectime(realpath($filepath)));
}

<?php

namespace Senna\Utils;

function get_size_within_bounds(int $maxWidth, ?int $maxHeight) {
    $width = $this->width;
    $height = $this->height;

    if ($maxWidth && $width > $maxWidth) {
        $height = $height * ($maxWidth / $width);
        $width = $maxWidth;
    }

    if ($maxHeight && $height > $maxHeight) {
        $width = $width * ($maxHeight / $height);
        $height = $maxHeight;
    }

    return [
        'width' => $width,
        'height' => $height,
    ];
}

<?php

it('i return the correct model path', function()
{
    // Get correct path name
    $path = senna_model('MediaItem', 'Media');

    expect($path)->toBe("\Senna\Media\Models\MediaItem");
});
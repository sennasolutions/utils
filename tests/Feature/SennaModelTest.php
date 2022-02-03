<?php

namespace Senna\Utils\Tests\Feature;

use Senna\Utils\Exceptions\HookException;
use Senna\Utils\Hook;
use Senna\Utils\Tests\TestCase;

class SennaModelTest extends TestCase
{
    public function testSennaModelCorrectPathName()
    {
        // Get correct path name
        $path = senna_model('MediaItem', 'Media');

        $this->assertEquals("\Senna\Media\Models\MediaItem", $path);
    }

}

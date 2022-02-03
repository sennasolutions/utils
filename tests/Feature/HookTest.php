<?php

namespace Senna\Utils\Tests\Feature;

use Senna\Utils\Exceptions\HookException;
use Senna\Utils\Hook;
use Senna\Utils\Tests\TestCase;

class HookTest extends TestCase
{
    public function testHookMultipleArgs()
    {
        Hook::clearHooks();

        Hook::register('test', function ($a, $b) {
            return $a + $b;
        });

        $this->assertEquals(3, Hook::run('test', 1, 2));
    }

    public function testHookForgettingReturn()
    {
        Hook::clearHooks();
        $this->expectException(HookException::class);

        Hook::register('test', function ($a, $b) {
            // Do nothing
        });

        Hook::run('test', 1, 2);
    }

    public function testHookMultipleHooks()
    {
        Hook::clearHooks();

        Hook::register('test', function ($a, $b) {
            return $a + $b;
        });

        Hook::register('test', function ($a, $b) {
            return $a * $b;
        });

        $this->assertEquals(6, Hook::run('test', 1, 2));
    }

    public function testHookMultipleHooksWithPriority()
    {
        Hook::clearHooks();
        
        Hook::register('test', function ($a, $b) {
            return $a + $b;
        }, 5);

        Hook::register('test', function ($a, $b) {
            return $a * $b;
        }, 1);

        $this->assertEquals(4, Hook::run('test', 1, 2));
    }
}

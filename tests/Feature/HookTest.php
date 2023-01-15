<?php

use Senna\Utils\Exceptions\HookException;
use Senna\Utils\Hook;

it('can has multiple args', function()
{
    Hook::clearHooks();

    Hook::register('test', function ($a, $b) {
        return $a + $b;
    });

    expect(Hook::run('test', 1, 2))->toBe(3);

    // $this->assertEquals(3, Hook::run('test', 1, 2));
});

it('it should give exception on no return specified', function()
{
    Hook::clearHooks();
    $this->expectException(HookException::class);

    Hook::register('test', function ($a, $b) {
        // Do nothing
    });

    Hook::run('test', 1, 2);
});

it('it can run mulitple hooks', function()
{
    Hook::clearHooks();

    Hook::register('test', function ($a, $b) {
        return $a + $b;
    });

    Hook::register('test', function ($a, $b) {
        return $a * $b;
    });

    expect(Hook::run('test', 1, 2))->toBe(6);
});

it('can run multiple hooks with priority', function()
{
    Hook::clearHooks();
    
    Hook::register('test', function ($a, $b) {
        return $a + $b;
    }, 5);

    Hook::register('test', function ($a, $b) {
        return $a * $b;
    }, 1);

    expect(Hook::run('test', 1, 2))->toBe(4);
});
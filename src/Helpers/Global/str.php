<?php

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

function str($string) : Stringable {
    return Str::of($string);
}
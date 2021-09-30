<?php

namespace Senna\Utils;

use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider {

    // public function register()
    // {

    // }

    public function boot() {
        Helpers::include(__DIR__ . '/Helpers');
    }
}
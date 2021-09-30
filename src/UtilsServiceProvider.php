<?php

namespace Senna\Utils;

use Illuminate\Support\ServiceProvider;

class UtilsServiceProvider extends ServiceProvider {

    // public function register()
    // {

    // }

    public function boot() {
        Helpers::include(__DIR__ . '/Helpers');
    }
}
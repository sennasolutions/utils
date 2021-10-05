<?php

namespace Senna\Utils;

use Illuminate\Support\ServiceProvider;
use Senna\Utils\SnapCache;

class UtilsServiceProvider extends ServiceProvider {

    public function register() {
        /**
         * https://laravel.com/docs/8.x/container#binding-scoped
         */
        $this->app->scoped(SnapCache::class);
    }

    public function boot() {
        Helpers::include(__DIR__ . '/Helpers/Global', $inGlobalScope = true);
        Helpers::include(__DIR__ . '/Helpers/Namespaced', $inGlobalScope = false);
        Extensions::include(__DIR__ . '/Extensions');
    }
}
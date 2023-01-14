<?php

namespace Senna\Utils;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Senna\Utils\SnapCache;

use Illuminate\Pagination\LengthAwarePaginator;
use Senna\Utils\Console\InstallCommand;

class UtilsServiceProvider extends ServiceProvider {

    public function register() {
        /**
         * https://laravel.com/docs/8.x/container#binding-scoped
         */
        $this->app->scoped(SnapCache::class);

        $this->commands([
            InstallCommand::class,
        ]);

        Helpers::include(__DIR__ . '/Helpers/Global', $inGlobalScope = true);
        Helpers::include(__DIR__ . '/Helpers', $inGlobalScope = false);

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page', $queryParams = null) {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                    'query' => isset($queryParams) ? $queryParams : request()->query()
                ]
            );
        });
    }

    public function boot() {
        Extensions::include(__DIR__ . '/Extensions');
    }
}
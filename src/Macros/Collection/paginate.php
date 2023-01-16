<?php

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

if (Collection::hasMacro('paginate')) return;

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
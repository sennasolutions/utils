<?php

/**
 * Checks if route is currently active
 *
 * @param [type] $name
 * @param array $params
 * @return void
 */
function route_is_active($name, $params = [])
{
    $request = request();
    $fingerpint = $request->get('fingerprint');
    $fingerpintPath = ($fingerpint && $fingerpint['path']) ? "/" . $fingerpint['path'] : null;

    return $request->routeIs($name, $params) || ( $fingerpintPath === route($name, $params, false));
}


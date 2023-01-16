<?php

function senna_data($name) {
    $path = __DIR__ . "/../../Data/";

    // Sanitize name so it cannot escape directory
    $name = preg_replace('/[^a-zA-Z0-9_\-]/', '', $name);

    return include($path . $name . ".php");
}
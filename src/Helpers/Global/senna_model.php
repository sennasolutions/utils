<?php

/**
 * Get the class path of a model within the senna realm.
 * 
 * @example senna_model('MediaItem', 'Media')
 *
 * @param string $name
 * @param boolean|string $plugin
 * @return string
 */
function senna_model(string $name, string|bool $plugin = false) : string {
    $snake = (string) str($name)->snake();
    $studly = (string) str($name)->studly();

    $pluginSnake = '';
    $pluginStudly = '';

    if ($plugin) {
        $pluginSnake = str($plugin)->lower() . '.';
        $pluginStudly = str($plugin)->studly() . '\\';
    }

    return config("senna." . $pluginSnake . "models.{$snake}", "\Senna\\" . $pluginStudly . "Models\\$studly");
}

<?php

namespace Senna\Utils\Addons;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use function Senna\Utils\Helpers\path_contains_file;

abstract class AddonServiceProvider extends ServiceProvider
{
    abstract public function getName() : string;
    abstract public function getAssetsDir() : ?string;
    abstract public function getSlug() : string;

    abstract public static function getPluginDir($filePath = "") : string;

    /**
     * Run the install from senna:install
     *
     * @return void
     */
    public function install(Command $command, array $extra = []) : bool
    {
        return false;
    }

    public function publish($tag)
    {
        Artisan::call('vendor:publish', ['--provider' => static::class, '--tag' => $tag]);

        echo Artisan::output();
    }

    /**
     * Helper function for a migration
     *
     * @param string $name
     * @return void
     */
    public function publishesMigration(string $name) : void {
        if (!path_contains_file(database_path('migrations/'), "$name")) {
            $this->publishes([
                static::getPluginDir("database/migrations/$name.stub.php") => database_path('migrations/' . date('Y_m_d_His', time()) . "_$name.php"),
                // you can add any number of migrations here
            ], 'senna.cms.migrations');
        }
    }

    public function includeHelpers($helpersDir) {
        foreach (scandir($helpersDir) as $helperFile) {
            $path = $helpersDir . "/" . $helperFile;

            if (! is_file($path)) {
                continue;
            }

            $function = Str::before($helperFile, '.php');

            if (function_exists($function)) {
                continue;
            }

            require_once $path;
        }
    }

    /**
     * A helper function for publishing boilerplate
     *
     * @param string $type config|migration|view
     * @param string $fileWithoutExtension
     * @param [type] $time
     * 
     * @return void
     */
    protected function publishesSome($type = "config", $fileWithoutExtension = "create_senna_activity_migrations") {
        if (app()->runningInConsole()) {
            $time = time() + 100; // So that its run after depedency migrations

            if ($type === "migration.fixed" || $type === "migrations.fixed") {
                $stub = static::getPluginDir("database/migrations/{$fileWithoutExtension}.stub.php");
                
                $this->publishes([
                    $stub => database_path('migrations/' . "{$fileWithoutExtension}.php"),
                ], 'migrations');
            }

            if ($type === "migration" || $type === "migrations") {
                // Search the path for the migration
                $newFilename = path_contains_file(database_path('migrations/'), $fileWithoutExtension, use_str_contains: true, return_filename: true);
                $newFilename = $newFilename ? $newFilename : date('Y_m_d_His', $time) . "_{$fileWithoutExtension}.php";

                $stub = static::getPluginDir("database/migrations/{$fileWithoutExtension}.stub.php");
                    
                $this->publishes([
                    $stub => database_path('migrations/' . $newFilename),
                ], 'migrations');

            }
            
            if ($type === "config") {
                $this->publishes([
                    static::getPluginDir("config/{$fileWithoutExtension}.php") => config_path("{$fileWithoutExtension}.php"),
                ], 'config');
            }

            if ($type === "view" || $type === "views") {
                $this->publishes([
                    static::getPluginDir('resources/views') => resource_path('views/vendor/' . $fileWithoutExtension),
                ], 'views');
            }
        }
    }
}

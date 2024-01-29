<?php

namespace Senna\Utils;

use Illuminate\Support\Facades\Blade;
use Senna\PackageTools\Package;
use Senna\PackageTools\PackageServiceProvider;
use Senna\Utils\Components\Delegate;

class UtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $this->app->singleton(SnapCache::class, function ($app) {
            return new SnapCache();
        });
        
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('utils')
            ->prefix('senna')
            // ->hasConfigFile()
            ->hasViews()
            // ->hasMigration('create_shared_table')
            ->hasHelperDirectory("Helpers", inGlobalScope: false)
            ->hasHelperDirectory("Helpers/Global", inGlobalScope: true)
            ->hasMacroDirectory("Macros/Carbon")
            ->hasMacroDirectory("Macros/Collection")
            ->hasMacroDirectory("Macros/Stringable")
            ->hasMacroDirectory("Macros/ComponentAttributeBag")
            // ->hasCommand(UtilsCommand::class)
            ;
    }

    public function bootingPackage()
    {
        Blade::component(Delegate::class, 'senna.delegate');
    }
}

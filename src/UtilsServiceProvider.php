<?php

namespace Senna\Utils;

use Senna\PackageTools\Package;
use Senna\PackageTools\PackageServiceProvider;

class UtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('shared')
            // ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_shared_table')
            ->hasHelperDirectory("Helpers", inGlobalScope: false)
            ->hasHelperDirectory("Helpers/Global", inGlobalScope: true)
            ->hasMacroDirectory("Macros/Carbon")
            ->hasMacroDirectory("Macros/Collection")
            ->hasMacroDirectory("Macros/Stringable")
            // ->hasCommand(UtilsCommand::class)
            ;
    }
}

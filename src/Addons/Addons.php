<?php

namespace Senna\Utils\Addons;

use Illuminate\Console\Command;

class Addons
{
    public static $addons = [];

    public static function register(AddonServiceProvider $provider, $prio = 100) {
        self::$addons[] = [$provider, $prio];
    }

    public static function get($slug) : ?AddonServiceProvider {
        return collect(static::$addons)->first(function($addon) use ($slug) {
            return $addon->getSlug() == $slug;
        })[0];
    }

    public static function install(Command $command)
    {
        $addons = collect(static::$addons)->sortBy(fn($addon) => $addon[1]);

        $requestedAddons = collect($command->argument('addon'))->groupBy(fn($addon) => (string) str($addon)->before("."));

        foreach($requestedAddons as $group => $requestedAddonSegments) {
            // Filter addons containing a dot
            $withDot = collect($requestedAddonSegments)
                ->filter(fn($addon) => str($addon)->contains("."))
                ->map(fn($addon) => str($addon)->after("."));

            foreach ($addons as $addonArr) {
                $addon = $addonArr[0];

                if ($addon->getSlug() == $group) {
                    $command->comment("---");
                    $command->comment("{$addon->getName()}.");
                    $command->comment("---");
                    
                    $workDone = $addon->install($command, $withDot->toArray());
                    if ($workDone) {
                        // $command->comment("{$addon->getName()} installed successfully.");
                    }
                }
            }
        }
        
        if ($requestedAddons->isEmpty()) {
            foreach ($addons as $addonArr) {
                $addon = $addonArr[0];
                
                
                $command->comment("-------------------------------------------------------");
                // $command->comment("---");
                $command->comment("{$addon->getName()}.");
                $command->comment("-------------------------------------------------------");
                
                $workDone = $addon->install($command);
                if ($workDone) {
                    // $command->comment("{$addon->getName()} installed successfully.");
                }
            }
        }
    }
}

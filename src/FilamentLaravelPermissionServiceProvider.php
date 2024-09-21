<?php

namespace Abdelhammied\FilamentLaravelPermission;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLaravelPermissionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name(name: 'filament-laravel-permission')
            ->hasRoutes()
            ->hasConfigFile('filament-laravel-permission')
            ->hasViews('filament-laravel-permission')
            ->publishesServiceProvider("Abdelhammied\FilamentLaravelPermission\FilamentLaravelPermissionServiceProvider")
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('abdelhammied/filament-laravel-permission');
            });
    }
}

<?php

namespace Abdelhammied\FilamentLaravelPermission;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentLaravelPermissionPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-laravel-permission';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            RoleResource::class,
            PermissionResource::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

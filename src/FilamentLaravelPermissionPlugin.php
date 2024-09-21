<?php
namespace Abdelhammied\FilamentLaravelPermission;

use Abdelhammied\FilamentLaravelPermission\Traits\HasAuthorization;
use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationBuilder;
use Filament\Support\Concerns\EvaluatesClosures;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;

class FilamentLaravelPermissionPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-laravel-permission';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            RoleResource::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

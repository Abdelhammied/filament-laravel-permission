<?php

namespace Abdelhammied\FilamentLaravelPermission;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;
use Filament\Navigation\NavigationGroup;

class FilamentLaravelPermission
{
    public function navigationGroup()
    {
        return NavigationGroup::make('Roles')
            ->items([
                ...RoleResource::getNavigationItems(),
                ...PermissionResource::getNavigationItems(),
            ])
            ->icon('heroicon-o-lock-closed');
    }
}

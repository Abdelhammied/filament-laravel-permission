<?php

namespace Abdelhammied\FilamentLaravelPermission;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource;
use Filament\Navigation\NavigationGroup;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;

class FilamentLaravelPermission
{
    public function navigationGroup()
    {
        return NavigationGroup::make('Roles')
            ->items([
                ...RoleResource::getNavigationItems(),
                ...PermissionResource::getNavigationItems()
            ])
            ->icon('heroicon-o-lock-closed');
    }
}

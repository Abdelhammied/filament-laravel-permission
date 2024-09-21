<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource\Pages;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

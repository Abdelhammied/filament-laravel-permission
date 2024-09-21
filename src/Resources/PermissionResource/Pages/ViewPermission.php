<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource\Pages;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

    public function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

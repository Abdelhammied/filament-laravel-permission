<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources\RoleResource\Pages;

use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    public function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

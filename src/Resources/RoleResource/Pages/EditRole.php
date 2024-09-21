<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources\RoleResource\Pages;

use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['guard_name'] = config('filament-laravel-permission.guards.use_single_default_guard')
            ? config('filament-laravel-permission.guards.default_guard')
            : $data['guard_name'];

        return [
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
        ];
    }

    public function afterSave()
    {
        $record = $this->record;
        $permissions = $this->data['permissions'] ?? [];

        $permissions = collect($permissions)->filter()->keys();

        $record->syncPermissions($permissions);
    }
}

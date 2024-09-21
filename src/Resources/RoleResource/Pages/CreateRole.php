<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources\RoleResource\Pages;

use Spatie\Permission\Models\Role;
use Filament\Resources\Pages\CreateRecord;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $guard_name = config('filament-laravel-permission.guards.use_single_default_guard')
            ? config('filament-laravel-permission.guards.default_guard')
            : $data['guard_name'];

        return [
            'name' => $data['name'],
            'guard_name' => $guard_name,
        ];
    }

    public function afterCreate()
    {
        /** @var Role $record */
        $record = $this->record;

        $permissions = $this->data['permissions'] ?? [];

        $permissions = collect($permissions)->filter()->keys()->toArray();

        $record?->syncPermissions($permissions);
    }
}

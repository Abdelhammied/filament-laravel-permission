<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Abdelhammied\FilamentLaravelPermission\Tables\Columns\RolePermissionColumn;
use Abdelhammied\FilamentLaravelPermission\Resources\RoleResource\Pages;
use Closure;
use Filament\Forms\Get;

class RoleResource extends Resource
{
    protected static ?string $navigationGroup = 'Roles';

    public static function getModel(): string
    {
        return config('permission.models.role');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->label('Role Name')
                        ->placeholder('Enter Role Name')
                        ->required(),

                    Forms\Components\Select::make('guard_name')
                        ->label('Guard Name')
                        ->placeholder('Select Guard Name')
                        ->required()
                        ->live()
                        ->default(config('filament-laravel-permission.guards.default_guard'))
                        ->hidden(config('filament-laravel-permission.guards.use_single_default_guard'))
                        ->options(config('filament-laravel-permission.guards.options')),

                    Forms\Components\Section::make('Permissions')
                        ->schema(self::formPermissionsComponents())
                        ->headerActions(self::formHeaderActions())
                ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        /** @var Role $record */
        $record = $infolist->getRecord();

        /** @var Collection $permissionGroups */
        $permissionGroups = self::permissionGroup($record?->guard_name);

        /** @var Permission $permissions */
        $permissions = $record->permissions;

        return $infolist
            ->schema([
                Infolists\Components\Section::make([
                    Infolists\Components\TextEntry::make('name')
                        ->label('Role Name'),

                    Infolists\Components\TextEntry::make('guard_name')
                        ->hidden(config('filament-laravel-permission.guards.use_single_default_guard'))
                        ->label('Guard Name'),

                    Infolists\Components\TextEntry::make('Users Count')
                        ->getStateUsing(fn(Role $role) => $role->users()->count()),

                    ...$permissionGroups->map(function ($permissionGroup, $group) use ($permissions) {
                        return Infolists\Components\Section::make($group)
                            ->collapsible(config('filament-laravel-permission.styling.permissions_collapsible'))
                            ->collapsed(config('filament-laravel-permission.styling.permissions_collapsed'))
                            ->columns(config('filament-laravel-permission.styling.permissions_columns'))
                            ->columnSpanFull()
                            ->schema(
                                $permissionGroup->map(function ($permission) use ($permissions) {
                                    return Infolists\Components\TextEntry::make($permission->name)
                                        ->label($permission->name)
                                        ->hint(
                                            $permissions->contains($permission)
                                            ? 'Granted'
                                            : 'Not Granted'
                                        )->hintColor(
                                            $permissions->contains($permission)
                                            ? 'success'
                                            : 'danger'
                                        )->hintIcon(
                                            $permissions->contains($permission)
                                            ? 'heroicon-o-check-circle'
                                            : 'heroicon-o-x-circle'
                                        );
                                })->toArray()
                            );
                    })->toArray(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var Collection $permissions */
        $permissions = Permission::get();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),

                RolePermissionColumn::make('permissions')
                    ->getStateUsing(
                        function (Role $role) {
                            $role->load('permissions');

                            return $role;
                        }
                    )
                    ->viewData([
                        'permissions' => $permissions,
                    ])
                    ->label('Permissions'),

                Tables\Columns\TextColumn::make('guard_name')
                    ->hidden(config('filament-laravel-permission.guards.use_single_default_guard')),

                Tables\Columns\TextColumn::make('users_count')->counts('users')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
            'view' => Pages\ViewRole::route('/{record}'),
        ];
    }

    public static function permissionGroup(string $guard = null): Collection
    {
        $guard_name = $guard ?? config('filament-laravel-permission.guards.default_guard');

        return self::permissionModelQuery()->where('guard_name', $guard_name)->get()->groupBy('group');
    }

    public static function formHeaderActions(): array
    {
        /** @var array $permissionIds */
        $permissionIds = self::permissionModelQuery()->get()->pluck('id')->toArray();

        if (!config('filament-laravel-permission.styling.show_form_permissions_header_actions')) {
            return [];
        }

        return [
            Forms\Components\Actions\Action::make('Select All')
                ->action(function (Set $set) use ($permissionIds) {
                    foreach ($permissionIds as $permissionId) {
                        $set('permissions.' . $permissionId, true);
                    }
                }),

            Forms\Components\Actions\Action::make('Deselect All')
                ->outlined()
                ->action(function (Set $set) use ($permissionIds) {
                    foreach ($permissionIds as $permissionId) {
                        $set('permissions.' . $permissionId, false);
                    }
                }),
        ];
    }

    public static function formPermissionsComponents(): Closure
    {
        return function (Get $get) {

            /** @var Collection $permissionGroups */
            $permissionGroups = self::permissionGroup($get('guard_name'));

            /** @var Collection $modelPermissions */
            $modelPermissions = $form->model?->permissions ?? collect([]);

            return $permissionGroups->map(function ($permissions, $group) use ($modelPermissions) {
                return Forms\Components\Section::make($group)
                    ->collapsible(config('filament-laravel-permission.styling.permissions_collapsible'))
                    ->collapsed(config('filament-laravel-permission.styling.permissions_collapsed'))
                    ->columns(config('filament-laravel-permission.styling.permissions_columns'))
                    ->columnSpanFull()
                    ->headerActions([
                        Forms\Components\Actions\Action::make('Select All')
                            ->action(function (Set $set) use ($permissions) {
                                $permissionIds = $permissions->pluck('id')->toArray();

                                foreach ($permissionIds as $permissionId) {
                                    $set('permissions.' . $permissionId, true);
                                }
                            }),

                        Forms\Components\Actions\Action::make('Deselect All')
                            ->outlined()
                            ->action(function (Set $set) use ($permissions) {
                                $permissionIds = $permissions->pluck('id')->toArray();

                                foreach ($permissionIds as $permissionId) {
                                    $set('permissions.' . $permissionId, false);
                                }
                            }),
                    ])
                    ->schema(
                        $permissions->map(function ($permission) use ($modelPermissions) {
                            return Forms\Components\Checkbox::make('permissions.' . $permission->id)
                                ->label($permission->name)
                                ->afterStateHydrated(static function (Forms\Components\Checkbox $component, $state) use ($modelPermissions, $permission): void {
                                    $component->state((bool) $modelPermissions->contains($permission->id));
                                });
                        })->toArray()
                    );
            })->flatten()->toArray();
        };
    }

    public static function permissionModelQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return config('permission.models.permission')::query();
    }
}

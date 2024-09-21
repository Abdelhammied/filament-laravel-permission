<?php

namespace Abdelhammied\FilamentLaravelPermission\Resources;

use Abdelhammied\FilamentLaravelPermission\Resources\PermissionResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    public static function getModel(): string
    {
        return config('permission.models.permission');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),

                Forms\Components\Select::make('guard_name')
                    ->label('Guard Name')
                    ->options(config('filament-laravel-permission.guards.options'))
                    ->required()
                    ->visible(! config('filament-laravel-permission.guards.use_single_default_guard')),

                Forms\Components\TextInput::make('group')
                    ->label('Group')
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make([
                Infolists\Components\TextEntry::make('name'),

                Infolists\Components\TextEntry::make('guard_name')
                    ->visible(! config('filament-laravel-permission.guards.use_single_default_guard')),

                Infolists\Components\TextEntry::make('group'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('guard_name')
                    ->visible(! config('filament-laravel-permission.guards.use_single_default_guard')),

                Tables\Columns\TextColumn::make('group'),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
            'view' => Pages\ViewPermission::route('/{record}'),
        ];
    }
}

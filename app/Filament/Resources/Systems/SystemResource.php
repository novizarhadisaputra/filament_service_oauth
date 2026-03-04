<?php

namespace App\Filament\Resources\Systems;

use App\Filament\Resources\Systems\Pages\CreateSystem;
use App\Filament\Resources\Systems\Pages\EditSystem;
use App\Filament\Resources\Systems\Pages\ListSystems;
use App\Filament\Resources\Systems\Pages\ManageSystemClients;
use App\Filament\Resources\Systems\Pages\ManageSystemUsers;
use App\Filament\Resources\Systems\Schemas\SystemForm;
use App\Filament\Resources\Systems\Tables\SystemsTable;
use App\Models\System;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemResource extends Resource
{
    protected static ?string $model = System::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;

    protected static string|\UnitEnum|null $navigationGroup = 'System Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SystemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SystemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditSystem::class,
            ManageSystemUsers::class,
            ManageSystemClients::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSystems::route('/'),
            'create' => CreateSystem::route('/create'),
            'edit' => EditSystem::route('/{record}/edit'),

            // Nested User Routes
            'users' => ManageSystemUsers::route('/{record}/users'),

            // Nested OAuth Client Routes
            'clients' => ManageSystemClients::route('/{record}/clients'),
        ];
    }
}

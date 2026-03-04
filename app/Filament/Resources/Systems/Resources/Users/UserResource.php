<?php

namespace App\Filament\Resources\Systems\Resources\Users;

use App\Filament\App\Resources\Users\Schemas\UserForm;
use App\Filament\App\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Systems\Resources\Users\Pages\CreateSystemUser;
use App\Filament\Resources\Systems\Resources\Users\Pages\EditSystemUser;
use App\Filament\Resources\Systems\Resources\Users\Pages\ListSystemUsers;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $parentResource = SystemResource::class;

    protected static bool $isDiscovered = false;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSystemUsers::route('/'),
            'create' => CreateSystemUser::route('/create'),
            'edit' => EditSystemUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Systems\Resources\Users;

use App\Filament\App\Resources\Users\Schemas\UserForm;
use App\Filament\App\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Systems\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Systems\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Systems\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Class UserResource
 *
 * User Resource.
 */
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = SystemResource::class;

    protected static ?string $recordTitleAttribute = 'email';

    /**
     * Execute Get Parent Resource Registration operation.
     *
     * @return \Filament\Resources\ParentResourceRegistration
     */
    public static function getParentResourceRegistration(): \Filament\Resources\ParentResourceRegistration
    {
        return parent::getParentResourceRegistration()
            ->relationship('users')
            ->inverseRelationship('systems');
    }

    /**
     * Execute Form operation.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    /**
     * Execute Table operation.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    /**
     * Execute Get Relations operation.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Execute Get Pages operation.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\App\Resources\Users;

use App\Filament\App\Resources\Users\Pages\CreateUser;
use App\Filament\App\Resources\Users\Pages\EditUser;
use App\Filament\App\Resources\Users\Pages\ListUsers;
use App\Filament\App\Resources\Users\Schemas\UserForm;
use App\Filament\App\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Pages\Page;
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

    protected static ?string $tenantRelationshipName = 'users';

    protected static ?string $tenantOwnershipRelationshipName = 'systems';

    protected static bool $isScopedToTenant = true;

    protected static ?string $navigationLabel = 'Users';

    protected static string|\UnitEnum|null $navigationGroup = 'Identity Management';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

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
     * Execute Get Eloquent Query operation.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if ($tenant = \Filament\Facades\Filament::getTenant()) {
            $query->whereHas('systems', fn ($subQuery) => $subQuery->where('systems.id', $tenant->id));
        }

        return $query;
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
     * Execute Get Record Sub Navigation operation.
     *
     * @param Page $page
     * @return array
     */
    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditUser::class,
        ]);
    }

    /**
     * Execute Get Pages operation.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}

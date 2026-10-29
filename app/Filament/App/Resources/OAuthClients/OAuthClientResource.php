<?php

namespace App\Filament\App\Resources\OAuthClients;

use App\Filament\App\Resources\OAuthClients\Pages\CreateOAuthClient;
use App\Filament\App\Resources\OAuthClients\Pages\EditOAuthClient;
use App\Filament\App\Resources\OAuthClients\Pages\ListOAuthClients;
use App\Filament\App\Resources\OAuthClients\Schemas\OAuthClientForm;
use App\Filament\App\Resources\OAuthClients\Tables\OAuthClientsTable;
use App\Models\OAuthClient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Class OAuthClientResource
 *
 * O Auth Client Resource.
 */
class OAuthClientResource extends Resource
{
    protected static ?string $model = OAuthClient::class;

    protected static ?string $tenantOwnershipRelationshipName = 'system';

    protected static ?string $navigationLabel = 'OAuth Clients';

    protected static string|\UnitEnum|null $navigationGroup = 'Identity Management';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    /**
     * Execute Form operation.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return OAuthClientForm::configure($schema);
    }

    /**
     * Execute Table operation.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return OAuthClientsTable::configure($table);
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
            'index' => ListOAuthClients::route('/'),
            'create' => CreateOAuthClient::route('/create'),
            'edit' => EditOAuthClient::route('/{record}/edit'),
        ];
    }
}

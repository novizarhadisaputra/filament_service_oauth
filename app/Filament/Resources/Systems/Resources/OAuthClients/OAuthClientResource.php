<?php

namespace App\Filament\Resources\Systems\Resources\OauthClients;

use App\Filament\App\Resources\OAuthClients\Schemas\OAuthClientForm;
use App\Filament\App\Resources\OAuthClients\Tables\OAuthClientsTable;
use App\Filament\Resources\Systems\Resources\OauthClients\Pages\CreateOauthClient;
use App\Filament\Resources\Systems\Resources\OauthClients\Pages\EditOauthClient;
use App\Filament\Resources\Systems\Resources\OauthClients\Pages\ViewOauthClient;
use App\Filament\Resources\Systems\Resources\OauthClients\Schemas\OauthClientInfolist;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\OauthClient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OauthClientResource extends Resource
{
    protected static ?string $model = OauthClient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = SystemResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OAuthClientForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     return OauthClientInfolist::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return OAuthClientsTable::configure($table);
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
            'create' => CreateOauthClient::route('/create'),
            'view' => ViewOauthClient::route('/{record}'),
            'edit' => EditOauthClient::route('/{record}/edit'),
        ];
    }
}

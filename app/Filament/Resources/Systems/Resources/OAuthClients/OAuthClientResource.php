<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients;

use App\Filament\App\Resources\OAuthClients\Schemas\OAuthClientForm;
use App\Filament\App\Resources\OAuthClients\Tables\OAuthClientsTable;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\CreateSystemClient;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\EditSystemClient;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\ListSystemClients;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\OAuthClient;
use Filament\Resources\ParentResourceRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class OAuthClientResource extends Resource
{
    protected static ?string $model = OAuthClient::class;

    protected static ?string $parentResource = SystemResource::class;

    protected static bool $isDiscovered = false;

    public static function getParentResourceRegistration(): ParentResourceRegistration
    {
        return parent::getParentResourceRegistration()
            ->relationship('clients')
            ->inverseRelationship('system');
    }

    public static function form(Schema $schema): Schema
    {
        return OAuthClientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OAuthClientsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSystemClients::route('/'),
            'create' => CreateSystemClient::route('/create'),
            'edit' => EditSystemClient::route('/{record}/edit'),
        ];
    }
}

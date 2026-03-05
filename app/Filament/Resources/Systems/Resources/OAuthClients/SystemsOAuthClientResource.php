<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients;

use App\Filament\App\Resources\OAuthClients\Schemas\OAuthClientForm;
use App\Filament\App\Resources\OAuthClients\Tables\OAuthClientsTable;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\CreateOAuthClient;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\EditOAuthClient;
use App\Filament\Resources\Systems\Resources\OAuthClients\Pages\ViewOAuthClient;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\OAuthClient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemsOAuthClientResource extends Resource
{
    protected static ?string $model = OAuthClient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = SystemResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getParentResourceRegistration(): \Filament\Resources\ParentResourceRegistration
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateOAuthClient::route('/create'),
            'view' => ViewOAuthClient::route('/{record}'),
            'edit' => EditOAuthClient::route('/{record}/edit'),
        ];
    }
}

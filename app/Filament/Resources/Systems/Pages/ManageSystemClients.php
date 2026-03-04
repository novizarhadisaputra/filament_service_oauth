<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\App\Resources\OAuthClients\Schemas\OAuthClientForm;
use App\Filament\App\Resources\OAuthClients\Tables\OAuthClientsTable;
use App\Filament\Resources\Systems\SystemResource;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManageSystemClients extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'clients';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static ?string $title = 'OAuth Clients';

    public function form(Schema $schema): Schema
    {
        return OAuthClientForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return OAuthClientsTable::configure($table)
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use App\Filament\Resources\Systems\SystemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;

class ManageSystemClients extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'clients';

    protected static ?string $relatedResource = SystemsOAuthClientResource::class;

    protected static ?string $title = 'OAuth Clients';

    protected static ?string $navigationLabel = 'OAuth Clients';

    protected static ?string $slug = 'oauth-clients';

    public function table(Table $table): Table
    {
        return SystemsOAuthClientResource::table($table)
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}

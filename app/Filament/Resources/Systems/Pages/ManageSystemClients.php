<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\OAuthClientResource;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\OAuthClient;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ManageSystemClients extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'clients';

    protected static ?string $relatedResource = OAuthClientResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

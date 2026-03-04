<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\OAuthClientResource;
use App\Filament\Resources\Systems\SystemResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class ManageSystemClients extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'clients';

    protected static ?string $relatedResource = OauthClientResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}

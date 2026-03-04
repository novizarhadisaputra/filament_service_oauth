<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\OAuthClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSystemClients extends ListRecords
{
    protected static string $resource = OAuthClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

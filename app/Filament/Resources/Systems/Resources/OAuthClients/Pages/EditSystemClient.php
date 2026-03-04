<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\OAuthClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSystemClient extends EditRecord
{
    protected static string $resource = OAuthClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Systems\Resources\OauthClients\Pages;

use App\Filament\Resources\Systems\Resources\OauthClients\OauthClientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOauthClient extends ViewRecord
{
    protected static string $resource = OauthClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

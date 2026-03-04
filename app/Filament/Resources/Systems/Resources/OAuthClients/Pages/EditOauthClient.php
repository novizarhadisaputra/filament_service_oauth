<?php

namespace App\Filament\Resources\Systems\Resources\OauthClients\Pages;

use App\Filament\Resources\Systems\Resources\OauthClients\OauthClientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOauthClient extends EditRecord
{
    protected static string $resource = OauthClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

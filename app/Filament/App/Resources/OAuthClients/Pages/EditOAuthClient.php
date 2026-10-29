<?php

namespace App\Filament\App\Resources\OAuthClients\Pages;

use App\Filament\App\Resources\OAuthClients\OAuthClientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Class EditOAuthClient
 *
 * Edit O Auth Client.
 */
class EditOAuthClient extends EditRecord
{
    protected static string $resource = OAuthClientResource::class;

    /**
     * Execute Get Header Actions operation.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Class EditOAuthClient
 *
 * Edit O Auth Client.
 */
class EditOAuthClient extends EditRecord
{
    protected static string $resource = SystemsOAuthClientResource::class;

    /**
     * Execute Get Header Actions operation.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

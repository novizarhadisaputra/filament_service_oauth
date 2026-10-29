<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Class ViewOAuthClient
 *
 * View O Auth Client.
 */
class ViewOAuthClient extends ViewRecord
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
            EditAction::make(),
        ];
    }
}

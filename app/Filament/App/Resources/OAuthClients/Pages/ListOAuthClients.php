<?php

namespace App\Filament\App\Resources\OAuthClients\Pages;

use App\Filament\App\Resources\OAuthClients\OAuthClientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Class ListOAuthClients
 *
 * List O Auth Clients.
 */
class ListOAuthClients extends ListRecords
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
            CreateAction::make(),
        ];
    }
}

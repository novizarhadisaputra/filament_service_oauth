<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Class CreateOAuthClient
 *
 * Create O Auth Client.
 */
class CreateOAuthClient extends CreateRecord
{
    protected static string $resource = SystemsOAuthClientResource::class;
}

<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOAuthClient extends CreateRecord
{
    protected static string $resource = SystemsOAuthClientResource::class;
}

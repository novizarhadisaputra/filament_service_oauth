<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\OAuthClientResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemClient extends CreateRecord
{
    protected static string $resource = OAuthClientResource::class;
}

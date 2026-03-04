<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}

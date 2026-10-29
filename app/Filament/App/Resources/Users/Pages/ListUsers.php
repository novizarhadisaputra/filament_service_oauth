<?php

namespace App\Filament\App\Resources\Users\Pages;

use App\Filament\App\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Class ListUsers
 *
 * List Users.
 */
class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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

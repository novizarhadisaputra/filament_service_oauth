<?php

declare(strict_types=1);

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Class ListRoles
 *
 * List Roles.
 */
class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    /**
     * Execute Get Actions operation.
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

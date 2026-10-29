<?php

declare(strict_types=1);

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Class ViewRole
 *
 * View Role.
 */
class ViewRole extends ViewRecord
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
            EditAction::make(),
        ];
    }
}

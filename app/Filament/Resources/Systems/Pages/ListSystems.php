<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 * Class ListSystems
 *
 * List Systems.
 */
class ListSystems extends ListRecords
{
    protected static string $resource = SystemResource::class;

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

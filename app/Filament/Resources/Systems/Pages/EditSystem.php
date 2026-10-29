<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Class EditSystem
 *
 * Edit System.
 */
class EditSystem extends EditRecord
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
            DeleteAction::make(),
        ];
    }
}

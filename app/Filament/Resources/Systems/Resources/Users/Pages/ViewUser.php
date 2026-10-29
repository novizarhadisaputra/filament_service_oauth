<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

/**
 * Class ViewUser
 *
 * View User.
 */
class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Execute Mount operation.
     *
     * @param int|string $record
     * @return void
     */
    public function mount(int|string $record): void
    {
        $parent = $this->getParentRecord();
        $systemParam = request()->route('system');
        $teamId = $parent?->id
            ?? ($systemParam instanceof \App\Models\System ? $systemParam->id : $systemParam);

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
        parent::mount($record);
    }

    /**
     * Execute Get Header Actions operation.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

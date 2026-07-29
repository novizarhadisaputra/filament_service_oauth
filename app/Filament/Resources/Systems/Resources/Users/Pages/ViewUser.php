<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

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

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

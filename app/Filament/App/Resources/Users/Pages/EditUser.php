<?php

namespace App\Filament\App\Resources\Users\Pages;

use App\Filament\App\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

    public function mount(int|string $record): void
    {
        $teamId = \Filament\Facades\Filament::getTenant()?->id ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
        parent::mount($record);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['roles'])) {
            $this->rolesToSave = (array) $data['roles'];
            unset($data['roles']);
        }

        return $data;
    }

    protected function beforeSave(): void
    {
        $teamId = \Filament\Facades\Filament::getTenant()?->id ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
    }

    protected function afterSave(): void
    {
        $teamId = \Filament\Facades\Filament::getTenant()?->id ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
            $roles = \App\Models\Role::whereIn('id', $this->rolesToSave)->get();
            $this->record->syncRoles($roles);
            $this->record->unsetRelation('roles');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

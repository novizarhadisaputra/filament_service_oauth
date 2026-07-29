<?php

namespace App\Filament\App\Resources\Users\Pages;

use App\Filament\App\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

    public function mount(): void
    {
        $teamId = \Filament\Facades\Filament::getTenant()?->id ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['roles'])) {
            $this->rolesToSave = (array) $data['roles'];
            unset($data['roles']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $teamId = \Filament\Facades\Filament::getTenant()?->id ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
            $roles = \App\Models\Role::whereIn('id', $this->rolesToSave)->get();
            $this->record->syncRoles($roles);
            $this->record->unsetRelation('roles');
        }
    }
}

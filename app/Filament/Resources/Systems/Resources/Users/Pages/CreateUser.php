<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

    public function mount(): void
    {
        $parent = $this->getParentRecord();
        if ($parent) {
            setPermissionsTeamId($parent->id);
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
        $parent = $this->getParentRecord();
        if ($parent) {
            setPermissionsTeamId($parent->id);
            $roles = \App\Models\Role::whereIn('id', $this->rolesToSave)->get();
            $this->record->syncRoles($roles);
            $this->record->unsetRelation('roles');
        }
    }
}

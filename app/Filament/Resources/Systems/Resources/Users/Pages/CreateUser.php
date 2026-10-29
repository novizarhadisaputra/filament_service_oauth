<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use App\Models\Role;
use App\Models\System;
use Filament\Resources\Pages\CreateRecord;

/**
 * Class CreateUser
 *
 * Create User.
 */
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

    /**
     * Execute Mount operation.
     * @return void
     */
    public function mount(): void
    {
        $parent = $this->getParentRecord();
        $systemParam = request()->route('system');
        $teamId = $parent?->id
            ?? ($systemParam instanceof System ? $systemParam->id : $systemParam);

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
        parent::mount();
    }

    /**
     * Execute Mutate Form Data Before Create operation.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['roles'])) {
            $this->rolesToSave = (array) $data['roles'];
            unset($data['roles']);
        }

        return $data;
    }

    /**
     * Execute After Create operation.
     * @return void
     */
    protected function afterCreate(): void
    {
        $parent = $this->getParentRecord();
        $systemParam = request()->route('system');
        $teamId = $parent?->id
            ?? ($systemParam instanceof System ? $systemParam->id : $systemParam);

        if ($teamId) {
            setPermissionsTeamId($teamId);
            $roles = Role::whereIn('id', $this->rolesToSave)->get();
            $this->record->syncRoles($roles);
            $this->record->unsetRelation('roles');
        }
    }
}

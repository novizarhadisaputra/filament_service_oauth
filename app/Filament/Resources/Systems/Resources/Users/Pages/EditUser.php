<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use App\Models\Role;
use App\Models\System;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Class EditUser
 *
 * Edit User.
 */
class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

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
            ?? ($systemParam instanceof System ? $systemParam->id : $systemParam);

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
        parent::mount($record);
    }

    /**
     * Execute Mutate Form Data Before Save operation.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['roles'])) {
            $this->rolesToSave = (array) $data['roles'];
            unset($data['roles']);
        }

        return $data;
    }

    /**
     * Execute Before Save operation.
     * @return void
     */
    protected function beforeSave(): void
    {
        $parent = $this->getParentRecord();
        $systemParam = request()->route('system');
        $teamId = $parent?->id
            ?? ($systemParam instanceof System ? $systemParam->id : $systemParam);

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }
    }

    /**
     * Execute After Save operation.
     * @return void
     */
    protected function afterSave(): void
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

    /**
     * Execute Get Header Actions operation.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

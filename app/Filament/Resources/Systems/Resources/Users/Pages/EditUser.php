<?php

namespace App\Filament\Resources\Systems\Resources\Users\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected array $rolesToSave = [];

    public function mount(int|string $record): void
    {
        $parent = $this->getParentRecord();
        if ($parent) {
            setPermissionsTeamId($parent->id);
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
        $parent = $this->getParentRecord();
        if ($parent) {
            setPermissionsTeamId($parent->id);
        }
    }

    protected function afterSave(): void
    {
        $parent = $this->getParentRecord();
        if ($parent) {
            setPermissionsTeamId($parent->id);
            $roles = \App\Models\Role::whereIn('id', $this->rolesToSave)->get();
            $this->record->syncRoles($roles);
            $this->record->unsetRelation('roles');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

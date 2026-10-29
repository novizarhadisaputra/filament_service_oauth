<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Roles\Pages;

use App\Filament\App\Resources\Roles\RoleResource;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class EditRole
 *
 * Edit Role.
 */
class EditRole extends EditRecord
{
    public Collection $permissions;

    protected static string $resource = RoleResource::class;

    /**
     * Execute Get Actions operation.
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Execute Mutate Form Data Before Save operation.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->permissions = collect($data)
            ->filter(fn (mixed $permission, string $key): bool => ! in_array($key, ['name', 'guard_name', 'select_all', Utils::getTenantModelForeignKey()]))
            ->values()
            ->flatten()
            ->unique();

        if (Utils::isTenancyEnabled() && Arr::has($data, Utils::getTenantModelForeignKey()) && filled($data[Utils::getTenantModelForeignKey()])) {
            return Arr::only($data, ['name', 'guard_name', Utils::getTenantModelForeignKey()]);
        }

        return Arr::only($data, ['name', 'guard_name']);
    }

    /**
     * Execute After Save operation.
     * @return void
     */
    protected function afterSave(): void
    {
        $permissionModels = collect();
        $this->permissions->each(function (string $permission) use ($permissionModels): void {
            $permissionModels->push(Utils::getPermissionModel()::firstOrCreate([
                'name' => $permission,
                'guard_name' => $this->data['guard_name'],
            ]));
        });

        // @phpstan-ignore-next-line
        $this->record->syncPermissions($permissionModels);
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * Class RolePolicy
 *
 * Role Policy.
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Execute View Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Role');
    }

    /**
     * Execute View operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function view(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('View:Role');
    }

    /**
     * Execute Create operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Role');
    }

    /**
     * Execute Update operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function update(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Update:Role');
    }

    /**
     * Execute Delete operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function delete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Delete:Role');
    }

    /**
     * Execute Restore operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function restore(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Restore:Role');
    }

    /**
     * Execute Force Delete operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function forceDelete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('ForceDelete:Role');
    }

    /**
     * Execute Force Delete Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Role');
    }

    /**
     * Execute Restore Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Role');
    }

    /**
     * Execute Replicate operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function replicate(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Replicate:Role');
    }

    /**
     * Execute Reorder operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Role');
    }

    /**
     * Execute Activate operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function activate(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Activate:Role');
    }

    /**
     * Execute Deactivate operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function deactivate(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Deactivate:Role');
    }

    /**
     * Execute Regenerate Secret operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function regenerateSecret(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('RegenerateSecret:Role');
    }

    /**
     * Execute Revoke operation.
     *
     * @param AuthUser $authUser
     * @param Role $role
     * @return bool
     */
    public function revoke(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('Revoke:Role');
    }
}

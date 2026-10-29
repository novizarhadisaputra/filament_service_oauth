<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * Class UserPolicy
 *
 * User Policy.
 */
class UserPolicy
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
        return $authUser->can('ViewAny:User');
    }

    /**
     * Execute View operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:User');
    }

    /**
     * Execute Create operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    /**
     * Execute Update operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function update(AuthUser $authUser): bool
    {
        return $authUser->can('Update:User');
    }

    /**
     * Execute Delete operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function delete(AuthUser $authUser): bool
    {
        return $authUser->can('Delete:User');
    }

    /**
     * Execute Restore operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:User');
    }

    /**
     * Execute Force Delete operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    /**
     * Execute Force Delete Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    /**
     * Execute Restore Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    /**
     * Execute Replicate operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User');
    }

    /**
     * Execute Reorder operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }

    /**
     * Execute Activate operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function activate(AuthUser $authUser): bool
    {
        return $authUser->can('Activate:User');
    }

    /**
     * Execute Deactivate operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function deactivate(AuthUser $authUser): bool
    {
        return $authUser->can('Deactivate:User');
    }

    /**
     * Execute Regenerate Secret operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function regenerateSecret(AuthUser $authUser): bool
    {
        return $authUser->can('RegenerateSecret:User');
    }

    /**
     * Execute Revoke operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function revoke(AuthUser $authUser): bool
    {
        return $authUser->can('Revoke:User');
    }
}

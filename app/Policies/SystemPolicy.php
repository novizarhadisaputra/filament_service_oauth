<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\System;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * Class SystemPolicy
 *
 * System Policy.
 */
class SystemPolicy
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
        return $authUser->can('ViewAny:System');
    }

    /**
     * Execute View operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function view(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('View:System');
    }

    /**
     * Execute Create operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:System');
    }

    /**
     * Execute Update operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function update(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Update:System');
    }

    /**
     * Execute Delete operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function delete(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Delete:System');
    }

    /**
     * Execute Restore operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function restore(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Restore:System');
    }

    /**
     * Execute Force Delete operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function forceDelete(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('ForceDelete:System');
    }

    /**
     * Execute Force Delete Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:System');
    }

    /**
     * Execute Restore Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:System');
    }

    /**
     * Execute Replicate operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function replicate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Replicate:System');
    }

    /**
     * Execute Reorder operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:System');
    }

    /**
     * Execute Activate operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function activate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Activate:System');
    }

    /**
     * Execute Deactivate operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function deactivate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Deactivate:System');
    }

    /**
     * Execute Regenerate Secret operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function regenerateSecret(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('RegenerateSecret:System');
    }

    /**
     * Execute Revoke operation.
     *
     * @param AuthUser $authUser
     * @param System $system
     * @return bool
     */
    public function revoke(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Revoke:System');
    }
}

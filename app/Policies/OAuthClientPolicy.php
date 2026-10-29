<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\OAuthClient;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

/**
 * Class OAuthClientPolicy
 *
 * O Auth Client Policy.
 */
class OAuthClientPolicy
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
        return $authUser->can('ViewAny:OAuthClient');
    }

    /**
     * Execute View operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function view(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('View:OAuthClient');
    }

    /**
     * Execute Create operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OAuthClient');
    }

    /**
     * Execute Update operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function update(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Update:OAuthClient');
    }

    /**
     * Execute Delete operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function delete(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Delete:OAuthClient');
    }

    /**
     * Execute Restore operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function restore(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Restore:OAuthClient');
    }

    /**
     * Execute Force Delete operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function forceDelete(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('ForceDelete:OAuthClient');
    }

    /**
     * Execute Force Delete Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OAuthClient');
    }

    /**
     * Execute Restore Any operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OAuthClient');
    }

    /**
     * Execute Replicate operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function replicate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Replicate:OAuthClient');
    }

    /**
     * Execute Reorder operation.
     *
     * @param AuthUser $authUser
     * @return bool
     */
    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OAuthClient');
    }

    /**
     * Execute Activate operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function activate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Activate:OAuthClient');
    }

    /**
     * Execute Deactivate operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function deactivate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Deactivate:OAuthClient');
    }

    /**
     * Execute Regenerate Secret operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function regenerateSecret(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('RegenerateSecret:OAuthClient');
    }

    /**
     * Execute Revoke operation.
     *
     * @param AuthUser $authUser
     * @param OAuthClient $oAuthClient
     * @return bool
     */
    public function revoke(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Revoke:OAuthClient');
    }
}

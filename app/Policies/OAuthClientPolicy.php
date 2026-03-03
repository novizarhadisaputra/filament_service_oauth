<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\OAuthClient;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class OAuthClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OAuthClient');
    }

    public function view(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('View:OAuthClient');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OAuthClient');
    }

    public function update(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Update:OAuthClient');
    }

    public function delete(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Delete:OAuthClient');
    }

    public function restore(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Restore:OAuthClient');
    }

    public function forceDelete(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('ForceDelete:OAuthClient');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OAuthClient');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OAuthClient');
    }

    public function replicate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Replicate:OAuthClient');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OAuthClient');
    }

    public function activate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Activate:OAuthClient');
    }

    public function deactivate(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Deactivate:OAuthClient');
    }

    public function regenerateSecret(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('RegenerateSecret:OAuthClient');
    }

    public function revoke(AuthUser $authUser, OAuthClient $oAuthClient): bool
    {
        return $authUser->can('Revoke:OAuthClient');
    }
}

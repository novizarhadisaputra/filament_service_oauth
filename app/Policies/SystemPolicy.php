<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\System;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SystemPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:System');
    }

    public function view(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('View:System');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:System');
    }

    public function update(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Update:System');
    }

    public function delete(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Delete:System');
    }

    public function restore(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Restore:System');
    }

    public function forceDelete(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('ForceDelete:System');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:System');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:System');
    }

    public function replicate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Replicate:System');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:System');
    }

    public function activate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Activate:System');
    }

    public function deactivate(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Deactivate:System');
    }

    public function regenerateSecret(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('RegenerateSecret:System');
    }

    public function revoke(AuthUser $authUser, System $system): bool
    {
        return $authUser->can('Revoke:System');
    }
}

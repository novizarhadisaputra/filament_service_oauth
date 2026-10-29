<?php

namespace App\Observers;

use App\Models\Role;
use App\Support\WebhookHelper;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleObserver
 *
 * Role Observer.
 */
class RoleObserver
{
    /**
     * Handle the Role "saved" event.
     * @param Role $role
     */
    public function saved(Role $role): void
    {
        DB::afterCommit(function () {
            WebhookHelper::notifyBackendCacheInvalidation();
        });
    }

    /**
     * Handle the Role "deleted" event.
     * @param Role $role
     */
    public function deleted(Role $role): void
    {
        DB::afterCommit(function () {
            WebhookHelper::notifyBackendCacheInvalidation();
        });
    }
}

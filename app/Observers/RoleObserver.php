<?php

namespace App\Observers;

use App\Models\Role;
use App\Support\WebhookHelper;
use Illuminate\Support\Facades\DB;

class RoleObserver
{
    /**
     * Handle the Role "saved" event.
     */
    public function saved(Role $role): void
    {
        DB::afterCommit(function () {
            WebhookHelper::notifyBackendCacheInvalidation();
        });
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        DB::afterCommit(function () {
            WebhookHelper::notifyBackendCacheInvalidation();
        });
    }
}

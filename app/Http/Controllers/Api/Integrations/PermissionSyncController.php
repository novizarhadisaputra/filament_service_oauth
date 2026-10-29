<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Integrations\PermissionSyncRequest;
use App\Http\Resources\PermissionSyncResource;
use App\Models\Permission;
use App\Models\System;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * Class PermissionSyncController
 *
 * Permission Sync Controller.
 */
class PermissionSyncController extends Controller
{
    use ApiResponse;

    /**
     * Sync permissions from a system.
     * @param PermissionSyncRequest $request
     * @return JsonResponse
     */
    public function sync(PermissionSyncRequest $request): JsonResponse
    {
        $system = System::where('slug', $request->system_slug)->firstOrFail();

        $synced = [];
        foreach ($request->permissions as $permissionName) {
            $permission = Permission::updateOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web'],
                ['name' => $permissionName]
            );
            $synced[] = $permission->name;
        }

        $result = [
            'system' => $system->slug,
            'count' => count($synced),
            'permissions' => $synced,
        ];

        return $this->successResponse(
            new PermissionSyncResource($result),
            'Permissions synced successfully'
        );
    }
}

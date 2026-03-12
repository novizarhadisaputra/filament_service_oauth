<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\System;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionSyncController extends Controller
{
    use ApiResponse;

    /**
     * Sync permissions from a system.
     */
    public function sync(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'system_slug' => 'required|string|exists:systems,slug',
            'permissions' => 'required|array',
            'permissions.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        $system = System::where('slug', $request->system_slug)->first();
        
        // Use Spatie Teams to scope permissions to the system if necessary, 
        // but typically permissions are global while roles are team-scoped.
        // However, to keep it clean, we'll just ensure they exist.

        $synced = [];
        foreach ($request->permissions as $permissionName) {
            $permission = Permission::updateOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web'],
                ['name' => $permissionName]
            );
            $synced[] = $permission->name;
        }

        return $this->successResponse([
            'system' => $system->slug,
            'count' => count($synced),
            'permissions' => $synced
        ], 'Permissions synced successfully');
    }
}

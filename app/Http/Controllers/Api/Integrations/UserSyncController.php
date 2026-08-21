<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Integrations\UserSyncRequest;
use App\Http\Resources\UserResource;
use App\Models\OAuthClient;
use App\Models\Role;
use App\Models\System;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserSyncController extends Controller
{
    use ApiResponse;

    /**
     * Sync user data from trusted internal source.
     */
    public function sync(UserSyncRequest $request): JsonResponse
    {
        // Try to find user by username or email (only check email if provided)
        $query = User::where('username', $request->username);
        
        if ($request->filled('email')) {
            $query->orWhere('email', $request->email);
        }
        
        $user = $query->first();

        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'metadata' => array_merge($user->metadata ?? [], $request->input('metadata', [])),
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password ?? str()->random(32)),
                'metadata' => $request->input('metadata', []),
            ]);
        }

        // Update password if provided (for JIT credential sync)
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Dynamically resolve target System (from request payload, client owner, or config default)
        $system = null;

        if ($request->filled('system_slug')) {
            $system = System::where('slug', $request->system_slug)->first();
        }

        if (! $system && $clientId = $request->header('X-Client-Id')) {
            $client = OAuthClient::withoutGlobalScopes()->where('client_id', $clientId)->first();
            $system = $client?->system;
        }

        if (! $system) {
            $system = System::where('slug', config('oauth.default_system_slug', 'simrs'))->first() 
                ?? System::first();
        }

        if ($system) {
            $user->systems()->syncWithoutDetaching([$system->id]);
            setPermissionsTeamId($system->id);
        }

        // Sync Roles if non-empty roles passed in payload, otherwise preserve existing OAuth roles for this system or fallback to 'User'
        $payloadRoles = array_filter((array) $request->input('roles', []));
        
        if (! empty($payloadRoles)) {
            $roleNames = $payloadRoles;
        } else {
            $existingRoles = $user->roles()
                ->where(function ($q) use ($system) {
                    if ($system) {
                        $q->where('roles.team_id', $system->id)
                          ->orWhereNull('roles.team_id');
                    }
                })
                ->pluck('name')
                ->toArray();

            if (! empty($existingRoles)) {
                $roleNames = $existingRoles;
            } elseif ($user->username === 'superadmin' || str_contains($user->email ?? '', 'superadmin')) {
                $roleNames = ['SuperAdmin'];
            } else {
                $roleNames = ['User'];
            }
        }

        foreach ($roleNames as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
                'team_id' => $system?->id,
            ]);
        }
        $user->syncRoles($roleNames);

        return $this->successResponse(new UserResource($user), 'User synced successfully');
    }
}

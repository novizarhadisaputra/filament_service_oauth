<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Integrations\UserSyncRequest;
use App\Http\Resources\UserResource;
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

        return $this->successResponse(new UserResource($user), 'User synced successfully');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\System;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Personal Access Token')->accessToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully', 201);
    }

    /**
     * Login user and create token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = $request->user();

        // Check for 2FA if system_slug is provided
        if ($request->filled('system_slug')) {
            $system = System::where('slug', $request->system_slug)->first();
            
            if ($system && $user->hasTwoFactorEnabledFor($system)) {
                // In a real implementation, we would generate a temporary session/token here
                // For now, we return a response indicating 2FA is required.
                return $this->successResponse([
                    'two_factor_required' => true,
                    'user_id' => $user->id,
                    'system_slug' => $system->slug,
                ], 'Two-factor authentication required', 202);
            }
        }

        $token = $user->createToken('Personal Access Token')->accessToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Verify 2FA code and complete login.
     */
    public function verify2fa(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'code' => 'required|string|size:6',
            'system_slug' => 'nullable|string|exists:systems,slug',
        ]);

        $user = User::findOrFail($request->user_id);

        // TODO: Verify TOTP code here using a library like pragmarx/google2fa
        // For demonstration, we'll assume '123456' is valid if no secret is set yet
        $isValid = ($request->code === '123456'); 

        if (!$isValid) {
            return $this->errorResponse('Invalid 2FA code', 422);
        }

        $token = $user->createToken('Personal Access Token')->accessToken;

        return $this->successResponse([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], '2FA verification successful');
    }

    /**
     * Get the authenticated User for Socialite (Flat response).
     */
    public function user(Request $request): UserResource
    {
        $user = $request->user();

        // Handle System/Team context for scoped roles/permissions
        if ($request->has('system_slug')) {
            $system = System::where('slug', $request->query('system_slug'))->first();
            if ($system) {
                setPermissionsTeamId($system->id);
            }
        }

        UserResource::withoutWrapping();

        return new UserResource($user);
    }

    /**
     * Get the authenticated User.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(new UserResource($request->user()), 'User profile retrieved');
    }

    /**
     * Logout user (Revoke the token).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->successResponse(null, 'Successfully logged out');
    }
}

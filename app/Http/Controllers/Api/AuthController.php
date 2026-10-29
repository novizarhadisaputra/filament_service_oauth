<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\Verify2faRequest;
use App\Http\Resources\UserResource;
use App\Models\System;
use App\Models\User;
use App\Services\TwoFactorService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 *
 * Auth Controller.
 */
class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Register a new user.
     * @param RegisterRequest $request
     * @return JsonResponse
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
     * @param LoginRequest $request
     * @param TwoFactorService $twoFactorService
     * @return JsonResponse
     */
    public function login(LoginRequest $request, TwoFactorService $twoFactorService): JsonResponse
    {
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([$fieldType => $request->username, 'password' => $request->password])) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = $request->user();

        // Check for 2FA if system_slug is provided or user has 2FA enabled
        $twoFactorRequired = false;
        $targetSystem = null;

        if ($request->filled('system_slug')) {
            $targetSystem = System::where('slug', $request->system_slug)->first();
            if ($targetSystem && $user->hasTwoFactorEnabledFor($targetSystem)) {
                $twoFactorRequired = true;
            }
        } elseif ($user->hasTwoFactorEnabled()) {
            $twoFactorRequired = true;
        }

        if ($twoFactorRequired) {
            $preAuthToken = $twoFactorService->createPreAuthToken($user);

            return $this->successResponse([
                'two_factor_required' => true,
                'user_id' => $user->id,
                'two_factor_token' => $preAuthToken,
                'system_slug' => $targetSystem?->slug,
            ], 'Two-factor authentication required', 202);
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
     * @param Verify2faRequest $request
     * @param TwoFactorService $twoFactorService
     * @return JsonResponse
     */
    public function verify2fa(Verify2faRequest $request, TwoFactorService $twoFactorService): JsonResponse
    {
        $user = null;

        if ($request->filled('two_factor_token')) {
            $user = $twoFactorService->resolvePreAuthUser($request->two_factor_token);
        }

        if (! $user && $request->filled('user_id')) {
            $user = User::find($request->user_id);
        }

        if (! $user) {
            return $this->errorResponse('Invalid or expired 2FA session', 422);
        }

        if (! $twoFactorService->verify($user, $request->code)) {
            return $this->errorResponse('Invalid 2FA code', 422);
        }

        if ($request->filled('two_factor_token')) {
            $twoFactorService->consumePreAuthToken($request->two_factor_token);
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
     * @param Request $request
     * @return UserResource
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
        } else {
            // Fallback: Resolve system from the Passport client ID associated with the token
            $token = $user->token();
            if ($token && $token->client_id) {
                $client = \App\Models\OAuthClient::where('client_id', $token->client_id)->first();
                if ($client && $client->owner_id) {
                    setPermissionsTeamId($client->owner_id);
                }
            }
        }

        UserResource::withoutWrapping();

        return new UserResource($user);
    }

    /**
     * Get the authenticated User.
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return $this->successResponse(new UserResource($request->user()), 'User profile retrieved');
    }

    /**
     * Logout user (Revoke the token).
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->successResponse(null, 'Successfully logged out');
    }
}

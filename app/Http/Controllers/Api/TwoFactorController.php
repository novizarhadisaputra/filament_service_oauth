<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Confirm2faRequest;
use App\Http\Requests\Api\Disable2faRequest;
use App\Http\Resources\TwoFactorSetupResource;
use App\Http\Resources\TwoFactorStatusResource;
use App\Services\TwoFactorService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TwoFactorController extends Controller
{
    use ApiResponse;

    /**
     * Get 2FA status for the authenticated user.
     */
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->successResponse(
            new TwoFactorStatusResource($user),
            '2FA status retrieved successfully'
        );
    }

    /**
     * Initiate 2FA setup: generate secret, OTP URL, and 100% offline SVG QR Code.
     */
    public function setup(Request $request, TwoFactorService $twoFactorService): JsonResponse
    {
        $user = $request->user();

        $secret = $twoFactorService->generateSecretKey();
        $otpAuthUrl = $twoFactorService->getOtpAuthUrl($user, $secret);
        $qrCodeSvg = $twoFactorService->getQrCodeSvg($otpAuthUrl);
        $recoveryCodes = $twoFactorService->generateRecoveryCodes();

        $setupData = [
            'secret' => $secret,
            'otpauth_url' => $otpAuthUrl,
            'qr_code_svg' => $qrCodeSvg,
            'recovery_codes' => $recoveryCodes,
        ];

        return $this->successResponse(
            new TwoFactorSetupResource($setupData),
            '2FA setup data generated successfully'
        );
    }

    /**
     * Confirm 2FA setup with initial code.
     */
    public function confirm(Confirm2faRequest $request, TwoFactorService $twoFactorService): JsonResponse
    {
        $user = $request->user();

        $confirmed = $twoFactorService->confirm(
            $user,
            $request->secret,
            $request->code,
            $request->input('recovery_codes', [])
        );

        if (! $confirmed) {
            return $this->errorResponse('Invalid verification code. Please check your authenticator app and try again.', 422);
        }

        return $this->successResponse(
            new TwoFactorStatusResource($user->fresh()),
            'Two-factor authentication confirmed and activated successfully'
        );
    }

    /**
     * Disable 2FA for the authenticated user.
     */
    public function disable(Disable2faRequest $request, TwoFactorService $twoFactorService): JsonResponse
    {
        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Password incorrect. Cannot disable 2FA.', 403);
        }

        $twoFactorService->disable($user);

        return $this->successResponse(
            new TwoFactorStatusResource($user->fresh()),
            'Two-factor authentication disabled successfully'
        );
    }
}

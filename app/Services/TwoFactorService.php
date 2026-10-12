<?php

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
        // Allow a window of 1 step (±30 seconds) to compensate for slight device clock drift
        $this->google2fa->setWindow(1);
    }

    /**
     * Generate a new base32 secret key.
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Generate the otpauth:// URI for Authenticator apps.
     */
    public function getOtpAuthUrl(User $user, string $secret): string
    {
        $company = config('app.name', 'RSUD Tarakan OAuth');
        $userIdentifier = !empty($user->username) ? (string) $user->username : (string) $user->email;

        return $this->google2fa->getQRCodeUrl(
            $company,
            $userIdentifier,
            $secret
        );
    }

    /**
     * Generate local SVG QR code (100% offline, zero external requests).
     */
    public function getQrCodeSvg(string $otpAuthUrl): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(200, 1),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        return $writer->writeString($otpAuthUrl);
    }

    /**
     * Generate emergency recovery codes.
     */
    public function generateRecoveryCodes(int $amount = 8): array
    {
        $codes = [];
        for ($i = 0; $i < $amount; $i++) {
            $codes[] = strtoupper(Str::random(5) . '-' . Str::random(5));
        }

        return $codes;
    }

    /**
     * Confirm and activate 2FA for a user.
     */
    public function confirm(User $user, string $secret, string $code, array $recoveryCodes = []): bool
    {
        if (! $this->google2fa->verifyKey($secret, $code)) {
            return false;
        }

        $user->two_factor_secret = $secret;
        $user->two_factor_recovery_codes = !empty($recoveryCodes) ? $recoveryCodes : $this->generateRecoveryCodes();
        $user->two_factor_confirmed_at = now();
        $user->save();

        return true;
    }

    /**
     * Disable 2FA for a user.
     */
    public function disable(User $user): bool
    {
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return true;
    }

    /**
     * Verify submitted 2FA code (TOTP or recovery code).
     */
    public function verify(User $user, string $code): bool
    {
        if (empty($user->two_factor_secret)) {
            return false;
        }

        $cleanCode = str_replace(' ', '', trim($code));

        // 1. Try TOTP code first
        if ($this->google2fa->verifyKey($user->two_factor_secret, $cleanCode)) {
            return true;
        }

        // 2. Try Recovery Codes
        $recoveryCodes = $user->two_factor_recovery_codes ?? [];
        if (is_array($recoveryCodes)) {
            $normalizedCode = strtoupper($cleanCode);
            foreach ($recoveryCodes as $index => $storedCode) {
                if (hash_equals(strtoupper($storedCode), $normalizedCode)) {
                    // Consume used recovery code
                    unset($recoveryCodes[$index]);
                    $user->two_factor_recovery_codes = array_values($recoveryCodes);
                    $user->save();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Create short-lived pre-auth token for 2FA challenge (5 minutes TTL).
     */
    public function createPreAuthToken(User $user): string
    {
        $token = '2fa_preauth_' . Str::random(64);
        Cache::put($token, $user->id, 300); // 5 minutes

        return $token;
    }

    /**
     * Resolve user from pre-auth token.
     */
    public function resolvePreAuthUser(string $token): ?User
    {
        $userId = Cache::get($token);
        if (! $userId) {
            return null;
        }

        return User::find($userId);
    }

    /**
     * Consume pre-auth token upon successful verification.
     */
    public function consumePreAuthToken(string $token): void
    {
        Cache::forget($token);
    }
}
